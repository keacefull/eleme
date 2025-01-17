<?php

namespace Abbotton\Eleme\Request;

class Common extends BaseRequest
{
    /**
     * 商户分类信息接口.
     *
     * @param  array  $params
     * @return mixed
     */
    public function shopCategories(array $params)
    {
        return $this->post('common.shopcategories', $params);
    }

    /**
     * 业态分类接口.
     *
     * @param  array  $params
     * @return mixed
     */
    public function businessCategories(array $params)
    {
        return $this->post('common.businesscategories', $params);
    }

    /**
     * 上传图片.
     *
     * @param  array  $params
     * @return mixed
     */
    public function upload(array $params)
    {
        return $this->post('picture.upload', $params);
    }

    /**
     * 城市信息接口文档.
     *
     * @param  array  $params
     * @return mixed
     */
    public function shopCities(array $params)
    {
        return $this->post('common.shopcities', $params);
    }

    /**
     * 查询商户分类信息.
     *
     * @param array $params
     * @return mixed
     */
    public function shopCategoryGet(array $params)
    {
        return $this->post('common.shop.category.get', $params);
    }

    /**
     * 获取城市信息.
     *
     * @param array $params
     * @return mixed
     */
    public function shopCityGet(array $params)
    {
        return $this->post('common.shop.city.get', $params);
    }
}
