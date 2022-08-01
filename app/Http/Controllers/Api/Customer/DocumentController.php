<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function lists(Request $request)
    {
        $customer = Customer::find($request->get('customer_id'));
        $files = $customer->documents()->where('document_category_id', $request->get('category'));
        $count = $files->count();
        $arr = [];

        foreach ($files->get() as $file) {
            $arr[] = [
                'reference' => $file->reference,
                'links' => '/storage/gdd/'.$customer.'/'.$request->get('category').'/'.$file->name.'.pdf',
            ];
        }

        ob_start();
        ?>
        <div class="card card-flush shadow-sm">
            <div class="card-body py-5">
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
                                <a href="<?= \Storage::url('gdd/'.$file->customer_id.'/'.$request->get('category').'/'.$file->name.'.pdf') ?>"
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
            </div>
        </div>
        <?php

        return response()->json([
            'files' => $files->get(),
            'count' => $count,
            'src' => $arr,
            'html' => ob_get_clean(),
        ]);

    }
}
