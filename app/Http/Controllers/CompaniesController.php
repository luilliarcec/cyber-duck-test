<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Models\Company;
use Illuminate\Support\Facades\Storage;

class CompaniesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): \Illuminate\Contracts\View\View
    {
        return view('companies.index', [
            'companies' => Company::query()->paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): \Illuminate\Contracts\View\View
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CompanyRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CompanyRequest $request): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['logo'])) {
            $data['logo'] = $request->file('logo')->store('public');
        }

        Company::create($data);

        return redirect()->back()
            ->with(['response' => __('response.success.create')]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Company $company
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Company $company): \Illuminate\Contracts\View\View
    {
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CompanyRequest $request
     * @param Company $company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CompanyRequest $request, Company $company): \Illuminate\Http\RedirectResponse
    {
        $data = $request->validated();

        if (isset($data['logo'])) {
            $data['logo'] = $request->file('logo')->store('public');

            if ($company->logo) {
                Storage::delete($company->logo);
            }
        }

        $company->update($data);

        return redirect()->back()
            ->with(['response' => __('response.success.edit')]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Company $company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Company $company)
    {
        if ($company->logo) {
            Storage::delete($company->logo);
        }

        $company->delete();

        return redirect()->back()
            ->with(['response' => __('response.success.delete')]);
    }
}
