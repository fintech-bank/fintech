<?php

namespace App\Http\Controllers\Admin;

use App\Helper\LogHelper;
use App\Http\Controllers\Controller;
use App\Models\Core\LoanPlan;
use App\Repository\Core\LoanPlanRepository;
use Illuminate\Http\Request;

class PretController extends Controller
{
    /**
     * @var LoanPlanRepository
     */
    private $loanPlanRepository;

    /**
     * PretController constructor.
     * @param LoanPlanRepository $loanPlanRepository
     */
    public function __construct(LoanPlanRepository $loanPlanRepository)
    {
        $this->loanPlanRepository = $loanPlanRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        return view('admin.prets.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'name' => "required|string",
            "min" => "required",
            "max" => "required",
            "duration" => "required",
        ]);

        try {
            $plan = LoanPlan::create([
                'name' => $request->get('name'),
                'min' => $request->get('min'),
                'max' => $request->get('max'),
                'duration' => $request->get('duration'),
                'instruction' => $request->get('instruction')
            ]);

            foreach ($request->get('loan_interests') as $interest) {
                $plan->interests()->create([
                    'interest' => $interest['interest'],
                    'duration' => $interest['duration'],
                    'loan_plan_id' => $plan->id
                ]);
            }

            LogHelper::notify('notice', "Création d'un plan de pret: ".$plan->name);
            return response()->json($plan);
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json($exception);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            LoanPlan::find($id)->delete();

            LogHelper::notify('notice', "Suppression d'un plan de pret");
            return response()->json();
        }catch (\Exception $exception) {
            LogHelper::notify('critical', $exception);
            return response()->json($exception);
        }
    }
}
