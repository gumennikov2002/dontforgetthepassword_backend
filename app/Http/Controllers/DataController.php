<?php

namespace App\Http\Controllers;


use App\Contracts\DataServiceContract;
use App\Http\Requests\CreateDataRequest;
use App\Http\Requests\DeleteDataRequest;
use App\Http\Requests\GetDataByIdRequest;
use App\Http\Requests\UpdateDataRequest;
use Illuminate\Http\JsonResponse;

class DataController extends Controller
{
    /**
     * Create user data
     *
     * @param CreateDataRequest $request
     * @param DataServiceContract $service
     * @return JsonResponse
     */
    public function create(CreateDataRequest $request, DataServiceContract $service): JsonResponse
    {
        return response()->json($service->create($request->all()));
    }

    /**
     * Delete user data
     *
     * @param DeleteDataRequest $request
     * @param DataServiceContract $service
     * @return JsonResponse
     */
    public function delete(DeleteDataRequest $request, DataServiceContract $service): JsonResponse
    {
        return response()->json($service->delete($request->id));
    }

    /**
     * Update user data
     *
     * @param UpdateDataRequest $request
     * @param DataServiceContract $service
     * @return JsonResponse
     */
    public function update(UpdateDataRequest $request, DataServiceContract $service): JsonResponse
    {
        return response()->json($service->update($request->all()));
    }


    /**
     * Get all user data records
     *
     * @param DataServiceContract $service
     * @return JsonResponse
     */
    public function getAll(DataServiceContract $service): JsonResponse
    {
        return response()->json($service->get());
    }


    /**
     * Get data record by id
     *
     * @param GetDataByIdRequest $request
     * @param DataServiceContract $service
     * @return JsonResponse
     */
    public function getById(GetDataByIdRequest $request, DataServiceContract $service): JsonResponse
    {
        return response()->json($service->get($request->id));
    }
}
