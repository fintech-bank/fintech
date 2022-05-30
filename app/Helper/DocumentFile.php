<?php


namespace App\Helper;


use App\Models\Core\DocumentCategory;
use App\Models\Customer\CustomerDocument;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class DocumentFile
{
    /**
     * @param $name
     * @param $customer
     * @param $category_id
     * @param null $reference
     * @param bool $signable
     * @param bool $signed_by_client
     * @param bool $signed_by_bank
     * @param null $signed_at
     * @param bool $pdf
     * @param null $viewPdf
     * @return \Exception
     */
    public function createDocument($name, $customer, $category_id, $reference = null, $signable = false, $signed_by_client = false, $signed_by_bank = false, $signed_at = null, $pdf = true, $viewPdf = null)
    {
        try {
            $category = DocumentCategory::find($category_id);
            $document = $customer->documents()->create([
                "name" => $name,
                "reference" => $reference != null ? $reference : \Str::upper(\Str::random(10)),
                "signable" => $signable,
                "signed_by_client" => $signed_by_client,
                "signed_by_bank" => $signed_by_bank,
                "signed_at" => $signed_at,
                "customer_id" => $customer->id,
                "document_category_id" => $category_id
            ]);
            if ($pdf == true) {
                $this->generatePDF(
                    $viewPdf,
                    $customer,
                    $document->id,
                    [],
                    false,
                    true,
                    public_path('/storage/gdd/'.$customer->id.'/'.\Str::slug($category->name)),
                    false);
            }

            return $document;
        } catch (\Exception $exception) {
            LogHelper::notify('critical', $exception->getMessage());
            return $exception;
        }
    }


    /**
     * @param $view
     * @param $customer
     * @param null $document_id
     * @param array $data
     * @param bool $download
     * @param bool $save
     * @param null $savePath
     * @param bool $stream
     * @param string $header_type
     * @return \Illuminate\Http\Response|null
     * @throws \Exception
     */
    public function generatePDF($view, $customer, $document_id = null, $data = [], $download = false, $save = false, $savePath = null, $stream = true, $header_type = 'simple')
    {
        $agence = $customer->user->agency;
        $document = $document_id != null ? CustomerDocument::find($document_id) : null;

        $pdf = PDF::loadView('pdf.' . $view, [
            "data" => $data,
            "agence" => $agence,
            "document" => $document,
            "title" => $document != null ? $document->name : 'Document',
            "header_type" => $header_type,
            "customer" => $customer
        ]);
        $pdf->setOptions([
            'enable-local-file-access' => true,
            'viewport-size' => '1280x1024',
            'footer-right' => '[page]/[topage]',
            'footer-font-size' => 8,
            'margin-left' => 0,
            'margin-right' => 0,
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);

        if ($download == true) {
            $pdf->download($document->name . ' - CUS' . $customer->user->identifiant . '.pdf');
        } else {
            return $pdf->stream($document->name . ' - CUS' . $customer->user->identifiant . '.pdf');
        }

        if ($save == true) {
            $pdf->save($savePath . '/' . $document->name . ' - CUS' . $customer->user->identifiant . '.pdf');
        } else {
            return $pdf->stream($document->name . ' - CUS' . $customer->user->identifiant . '.pdf');
        }

        if ($stream == true) {
            return $pdf->stream($document->name . ' - CUS' . $customer->user->identifiant . '.pdf');
        } else {
            return $pdf->render();
        }

        return null;
    }
}
