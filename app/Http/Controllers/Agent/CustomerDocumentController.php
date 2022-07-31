<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerDocument;
use App\Notifications\Customer\SendCodeToSignEmailNotification;
use App\Notifications\Customer\SendCodeToSignSMSNotification;
use Illuminate\Http\Request;

class CustomerDocumentController extends Controller
{
    public function show($customer, $category)
    {
        $files = CustomerDocument::query()->where('customer_id', $customer)->where('document_category_id', $category);
        $count = $files->count();

        $arrs = [];

        foreach ($files->get() as $file) {
            $arrs[] = [
                'reference' => $file->reference,
                'links' => '/storage/gdd/'.$customer.'/'.$category.'/'.$file->name.'.pdf',
            ];
        }

        ob_start(); ?>
        <table class="table table-bordered table-striped gy-5 gx-5">
            <thead>
            <tr class="fw-bolder">
                <th>Nom du fichier</th>
                <th>Signature</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($files->get() as $file) { ?>
                <tr>
                    <td><?= $file->name ?></td>
                    <td>
                        <?php if ($file->signable == 1) { ?>
                            <strong>Signé par la banque:</strong>
                            <?php if ($file->signed_by_bank == 1) { ?>
                                <span class="badge badge-success">Oui</span><br>
                            <?php } else { ?>
                                <span class="badge badge-danger">Non</span><br>
                            <?php } ?>
                            <strong>Signé par le client:</strong>
                            <?php if ($file->signed_by_client == 1) { ?>
                                <span class="badge badge-success">Oui</span><br>
                            <?php } else { ?>
                                <span class="badge badge-danger">Non</span><br>
                            <?php } ?>
                        <?php } else { ?>
                            <span class="badge badge-secondary">Non Signable</span>
                        <?php } ?>
                    </td>
                    <td>
                        <a href="<?= \Storage::url('gdd/'.$file->customer_id.'/'.$category.'/'.$file->name.'.pdf') ?>"
                           target="_blank" class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip"
                           title="Voir le Fichier"><i class="fa-solid fa-eye"></i> </a>
                        <?php if ($file->signed_by_client == 0 && $file->signable == 1) { ?>
                            <a href="<?= route('agent.customer.file.signRequest', [$file->customer_id, $file->id]) ?>"
                               class="btn btn-sm btn-icon btn-bank sign" data-bs-toggle="tooltip"
                               title="Signer le document"><i class="fa-solid fa-sign"></i> </a>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
        <?php

        return response()->json([
            'files' => $files->get(),
            'count' => $count,
            'src' => $arrs,
            'html' => ob_get_clean(),
        ]);
    }

    public function signRequest($customer, $file)
    {
        $file = CustomerDocument::find($file);

        $codeGenerate = random_numeric(8);

        $file->update(['code_sign' => base64_encode($codeGenerate)]);

        if ($file->customer->info->isVerified == 1) {
            $file->customer->info->notify(new SendCodeToSignSMSNotification($file, $codeGenerate));
        } else {
            $file->customer->user->notify(new SendCodeToSignEmailNotification($file, $codeGenerate));
        }

        return view('agent.customer.verify.sign', compact('file'));
    }

    public function sign(Request $request, $customer, $file)
    {
        $request->validate([
            'code_sign' => 'required|numeric',
        ]);

        $file = CustomerDocument::find($file);

        if ($file->code_sign == base64_encode($request->get('code_sign'))) {
            $file->update([
                'code_sign' => null,
                'signed_at' => now(),
                'signed_by_client' => 1,
            ]);
        } else {
            return response()->json(['errors' => ['Code Incorrect']], 500);
        }

        return response()->json($file);
    }
}
