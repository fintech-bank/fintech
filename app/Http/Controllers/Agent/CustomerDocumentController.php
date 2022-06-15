<?php

namespace App\Http\Controllers\Agent;

use App\Helper\DocumentFile;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerDocument;
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
                "reference" => $file->reference,
                "links" => '/storage/gdd/'.$customer.'/'.$category.'/'.$file->name.'.pdf'
            ];
        }

        ob_start();
        ?>
        <table class="table table-bordered table-striped gy-5 gx-5">
            <thead>
                <tr class="fw-bolder">
                    <th>Nom du fichier</th>
                    <th>Signature</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($files->get() as $file): ?>
                <tr>
                    <td><?= $file->name ?></td>
                    <td>
                        <?php if($file->signable == 1): ?>
                        <strong>Signé par la banque:</strong>
                            <?php if($file->signed_by_bank == 1): ?>
                            <span class="badge badge-success">Oui</span><br>
                            <?php else: ?>
                            <span class="badge badge-danger">Non</span><br>
                            <?php endif; ?>
                            <strong>Signé par le client:</strong>
                            <?php if($file->signed_by_client == 1): ?>
                                <span class="badge badge-success">Oui</span><br>
                            <?php else: ?>
                                <span class="badge badge-danger">Non</span><br>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="badge badge-secondary">Non Signable</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="<?= \Storage::url('gdd/'.$file->customer_id.'/'.$category.'/'.$file->name.'.pdf') ?>" class="btn btn-sm btn-icon btn-primary" data-bs-toggle="tooltip" title="Voir le Fichier"><i class="fa-solid fa-eye"></i> </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php

        return response()->json([
            "files" => $files->get(),
            "count" => $count,
            "src" => $arrs,
            "html" => ob_get_clean()
        ]);
    }
}
