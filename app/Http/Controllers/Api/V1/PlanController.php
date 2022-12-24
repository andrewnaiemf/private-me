<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Backend\Api\ApiRequest;
use App\Models\Auth\Plan;

class PlanController extends APIController
{
    public function index(ApiRequest $request)
    {
        $plan = Plan::all();

        return $plan;
    }

    public function add(ApiRequest $request)
    {
        $this->validate($request, [
            "name" => 'required',
            "duration" => 'required',
            "description" => 'required',
            "price_year" => 'required',
            "price_month" => 'required',
            "storage" => 'required',
            "free_storage" => 'required',
            "chat" => 'required',
            "friends" => 'required',
        ]);

        Plan::create($request->all());

        return response()->json(["success" => true, "msg" => "created successfully"]);
    }

    public function remove(ApiRequest $request)
    {
        $this->validate($request, [
            "id" => 'required',
        ]);

        $plan = Plan::find($request->id);
        $plan->delete();
        return response()->json(["success" => true, "msg" => "deleted successfully"]);
    }
}
