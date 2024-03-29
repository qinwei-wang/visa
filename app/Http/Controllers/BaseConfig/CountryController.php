<?php
/**
 * Created by PhpStorm.
 * User: sin
 * Date: 2019/5/5
 * Time: 17:02
 */


namespace App\Http\Controllers\BaseConfig;

use App\Http\Controllers\Controller;
use App\Services\CountryService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Requests\SaveVisaCountryRequest;

class CountryController extends Controller
{
    use ApiResponse;

    protected $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    /**
     * 首页国家列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $list = $this->countryService->getList($request->all());
        return view('countries.index', compact('list'));
    }



    /**
     * 移民详情
     */
    public function detail(Request $request)
    {
        $country_detail = $this->countryService->getDetail($request->country_id);
//        $advantages = $this->countryService->getAdvantages();
        $user_types = $this->countryService->getUserTypes();
        $apply_conditions = $this->countryService->getApplyConditions();
        $tags = $this->countryService->getTags();
        return view('countries.detail', compact('country_detail', 'advantages', 'user_types', 'apply_conditions', 'tags'));
    }


    /**
     * 保存国家移民详情设置
     * @param Request $request
     */
    public function saveDetail(Request $request)
    {
        try {
             $this->countryService->saveDetail($request->all());
             return $this->success();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \Log::error($e->getTraceAsString());
            return $this->failed($e->getMessage());
        }
    }


    public function saveSelectCountry(Request $request)
    {
        try {
            $this->countryService->saveSelectCountry($request->country_ids);
            return $this->success();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \Log::error($e->getTraceAsString());
            return $this->failed($e->getMessage());
        }
    }


    public function passport(Request $request)
    {
        $list = $this->countryService->getVisaCountries($request->all());
        $visa_types = $this->countryService->getVisaTypes();
        return view('countries.passport', compact('list', 'visa_types'));
    }


    public function visaCountries(Request $request)
    {
        $list = $this->countryService->getVisaCountries($request->all());
        $visa_types = $this->countryService->getVisaTypes();
        return view('countries.passport', compact('list', 'visa_types'));
    }


    public function selectCountries(Request $request)
    {
        $list = $this->countryService->getSelectCountries($request->all());
        return view('countries.select_countries', compact('list'));
    }

    public function selectVisaCountries(Request $request)
    {
        $list = $this->countryService->selectVisaCountries($request->all());
        $visa_types = $this->countryService->getVisaTypes();

        return view('countries.select_visa_countries', compact('list', 'visa_types'));
    }


    public function saveVisaCountry(SaveVisaCountryRequest $request)
    {
        try {
            $this->countryService->saveVisaCountry($request->all());
            return $this->success();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \Log::error($e->getTraceAsString());
            return $this->failed($e->getMessage());
        }
    }

    public function showVisaCountry(Request $request)
    {
        $visa_country = $this->countryService->showVisaCountry($request->id);
        return view('countries.create_or_edit_visa_country', compact('visa_country'));
    }

    public function deleteVisaCountry(Request $request)
    {
        try {
            $this->countryService->deleteVisaCountry($request->id);
            return $this->success();
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            \Log::error($e->getTraceAsString());
            return $this->failed($e->getMessage());
        }
    }


    public function delete(Request $request)
    {
        try {
            $this->countryService->delete($request->id);
            return $this->success();
        } catch(\Exception $e)
        {
            \Log::error($e->getMessage());
            \Log::error($e->getTraceAsString());
            return $this->failed($e->getMessage());
        }
    }


    public function sort(Request $request)
    {
        try {
            $this->countryService->sort($request->all());
            return $this->success();
        } catch(\Exception $e)
        {
            \Log::error($e->getMessage());
            \Log::error($e->getTraceAsString());
            return $this->failed($e->getMessage());
        }
    }
}