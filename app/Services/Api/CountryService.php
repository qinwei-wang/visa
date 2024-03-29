<?php
/**
 * Created by PhpStorm.
 * User: patpat
 * Date: 2019/5/10
 * Time: 12:06
 */


namespace App\Services\Api;
use App\Repositories\CountryRepository;
use App\Repositories\CountryDetailRepository;
use App\Repositories\VisaCountryRepository;
use App\Repositories\VisaTypeRepository;
use App\Services\Api\AdvantageService;
use App\Services\Api\UserTypeService;
use App\Services\Api\ApplyConditionService;
use App\Services\Api\TagService;


class CountryService
{
    protected $countryRepository;

    protected $countryDetailRepository;

    protected $visaCountryRepository;

    protected $advantageService;

    protected $userTypeService;

    protected $applyConditionService;

    protected $tagService;

    protected $visaTypeRepository;

    const ID_TYPES = [ 1 => '护照'];



    public function __construct(
        CountryRepository $countryRepository,
        CountryDetailRepository $countryDetailRepository,
        VisaCountryRepository $visaCountryRepository,
        AdvantageService $advantageService,
        UserTypeService $userTypeService,
        ApplyConditionService $applyConditionService,
        TagService $tagService,
        VisaTypeRepository $visaTypeRepository
    )
    {
        $this->countryRepository = $countryRepository;
        $this->countryDetailRepository = $countryDetailRepository;
        $this->visaCountryRepository = $visaCountryRepository;
        $this->advantageService = $advantageService;
        $this->userTypeService = $userTypeService;
        $this->applyConditionService = $applyConditionService;
        $this->tagService = $tagService;
        $this->visaTypeRepository = $visaTypeRepository;

    }

    public function getCountryInfo($params)
    {
        $result = [];
        $countries = $this->countryDetailRepository->makeModel()->get();
        foreach ($countries as $country) {
            $arr = [];
            $arr['country_id'] = $country->country->id;
            $arr['name'] = $country->country->ch_name;
            $arr['flag'] = $country->country->flag;
            $arr['banner'] = json_decode($country->banner, true);
            $arr['img'] = img_url($country->img);
            $arr['ID_type'] = isset(self::ID_TYPES[$country->ID_type]) ? self::ID_TYPES[$country->ID_type] : '';
            $arr['require'] = $country->live;
            $arr['migrate_cycle'] = $country->migrate;
            $arr['visa_free_number'] = $country->visa_free;
            $arr['description'] = $country->description;
            $arr['process'] = $country->process ? explode(',' , $country->process) : '';
            $arr['advantages'] = $country->advantage_ids ? $this->advantageService->getAdvantages(json_decode($country->advantage_ids, true)) : [];
            $arr['user_types'] = $country->user_type_ids ? $this->userTypeService->getUserTypes(json_decode($country->user_type_ids, true)) : [];
            $arr['apply_conditions'] = $country->apply_condition_ids ? $this->applyConditionService->getApplyConditions(json_decode($country->apply_condition_ids, true)) : [];
            $result[] = $arr;
        }
        return $result;
    }


    public function getPassports($params)
    {
        $result = [];
        $countries = $this->countryDetailRepository->makeModel()->get();
        foreach ($countries as $country) {
            $passport = [];
            $passport['country_id'] = $country->country_id;
            $passport['flag'] = $country->country->flag;
            $passport['passport'] = $country->passport;
            $passport['visa_free_number'] = $country->visa_free;
            $passport['rank'] = $country->rank;
            foreach ($country->country->hasManyVisaCountries as $k => $item) {
                $passport['visa_countries'][$k]['country_id'] = $item->visa_country_id;
                $passport['visa_countries'][$k]['type'] = $this->visaTypeRepository->getVisaTypeByid($item->type);
                $passport['visa_countries'][$k]['flag'] = $item->country->flag;
            }
            $result[] = $passport;
        }
        return $result;
    }


    /**
     * 获取国家信息
     * @param $country_id
     */
    public function getCountryInfoById($country_id)
    {
        $country = $this->countryDetailRepository->getDetailByCountryId($country_id);
        $data = [];
        $data['country_id'] = $country->country->id;
        $data['name'] = $country->country->ch_name;
        $data['en_name'] = $country->country->name;
        $data['flag'] = $country->country->flag;
        $data['banner'] = json_decode($country->banner, true);
        if (!empty($data['banner'])) {
            if (isset($data['banner']['img']['h5'])) {
                $data['banner']['img']['h5'] = isset($data['banner']['img']['h5']) ? img_url($data['banner']['img']['h5']) : '';
            }
            if (isset($data['banner']['img']['pc'])) {
                $data['banner']['img']['pc'] = isset($data['banner']['img']['pc']) ? img_url($data['banner']['img']['pc']) : '';
            }
        }
        $data['description'] = $country->description;
        $data['process'] = $country->process ? explode(';', $country->process) : '';
//        $data['advantages'] = $country->advantage_ids ? $this->advantageService->getAdvantages(json_decode($country->advantage_ids, true)) : [];
        $data['advantages'] = $this->advantageService->getAdvantagesByCountryId($country_id);
        $data['user_types'] = $country->user_type_ids ? $this->userTypeService->getUserTypes(json_decode($country->user_type_ids, true)) : [];
        $data['apply_conditions'] = $country->apply_condition_ids ? $this->applyConditionService->getApplyConditions(json_decode($country->apply_condition_ids, true)) : [];
        $advantage = json_decode($country->advantage,true);
        $disadvantage = json_decode($country->disadvantage,true);
        $data['different']['advantage']['title'] = $advantage['title'];
        $data['different']['advantage']['content'] = explode(';', $advantage['content']);
        $data['different']['disadvantage']['title'] = $disadvantage['title'];
        $data['different']['disadvantage']['content'] = explode(';', $disadvantage['content']);
        return $data;
    }


    public function getPassportsInfo()
    {
        $result = [];
        $countries = $this->countryDetailRepository->getAll();
        foreach ($countries as $country) {
            $passport = [];
            $passport['country_id'] = $country->country_id;
            $passport['name'] = $country->country->ch_name;
            $passport['flag'] = $country->country->flag;
            $passport['passport_img'] = img_url($country->passport);
            $passport['visa_free_number'] = $country->visa_free;
            $passport['rank'] = $country->rank;
            foreach ($country->country->hasManyVisaCountries as $k => $item) {
                $passport['visa_countries'][$k]['country_id'] = $item->visa_country_id;
                $passport['visa_countries'][$k]['name'] = $item->country->ch_name;
                $passport['visa_countries'][$k]['type'] = $this->visaTypeRepository->getVisaTypeByid($item->type);;
                $passport['visa_countries'][$k]['flag'] = $item->country->flag;
            }
            $result[] = $passport;
        }

        return $result;
    }


    public function getRecommendCountries($params)
    {
        $result = [];
        $countries = $this->countryDetailRepository->getAll();
        foreach ($countries as $country) {
            $arr = [];
            $arr['country_id'] = $country->country->id;
            $arr['name'] = $country->country->ch_name;
            $arr['en_name'] = $country->country->name;
            $arr['flag'] = $country->country->flag;
            $arr['img'] = img_url($country->img);
            $arr['passport'] = img_url($country->passport);
            $arr['ID_type'] = isset(self::ID_TYPES[$country->ID_type]) ? self::ID_TYPES[$country->ID_type] : '';
            $arr['require'] = $country->live;
            $arr['migrate_cycle'] = $country->migrate;
            $arr['visa_free_number'] = $country->visa_free;
            $arr['rank'] = $country->rank;
            $arr['introduction'] = $country->introduction;
            $arr['tags'] = $country->tags ? $this->tagService->getTags(json_decode($country->tags, true)) : [];
            $result[] = $arr;
        }
        return $result;
    }






}
