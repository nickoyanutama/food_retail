<?php

namespace FoodRetail\Service;

use FoodRetail\Repository\ProductRepository;
use FoodRetail\Entity\Product;
use Exception;
use FoodRetail\Config\Database;
use FoodRetail\Model\Request;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function validateExpired(Request $request)
    {
        $dateExpired = strtotime($request->expiredAt);
        $dateNow = strtotime(date('Y-m-d'));
        $expired = ($dateExpired - $dateNow) / 24 / 60 / 60;
        if ($expired <= 0) {
            $request->isExpired = 1;
        } else if ($expired < 10) {
            $request->discount = 0.1;
        }
    }

    public function index($activePage, $limitData)
    {
        $countAllData = count($this->productRepository->All());
        $totalPage = ceil($countAllData / $limitData);
        $firstData = ($limitData * $activePage) - $limitData;
        $data = $this->productRepository->Pagination($firstData, $limitData, $totalPage);
        return $data;
    }

    public function show($qrcode)
    {
        return $this->productRepository->findByQr($qrcode);
    }

    public function create(Request $request)
    {
        $this->validateExpired($request);
        $result = json_decode($this->productRepository->findByQr($request->qrcode));
        if (isset($result->status) != 404) {
            return json_encode(array('status' => 409, 'response' => 'Product Already Excist'));
        }

        try {
            Database::beginTransaction();

            $product = new Product();
            $product->setQrcode($request->qrcode);
            $product->setName($request->name);
            $product->setPrice($request->price);
            $product->setDiscount($request->discount);
            $product->setIsExpired($request->isExpired);
            $product->setExpiredAt($request->expiredAt);

            $this->productRepository->save($product);

            Database::commitTransaction();

            return json_encode(array('status' => 200, 'response' => "OK"));
        } catch (Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    public function update(Request $request)
    {
        $this->validateExpired($request);
        $result = json_decode($this->productRepository->findById($request->id));
        if (isset($result->status) == 404) {
            return json_encode(array('status' => 404, 'response' => 'Product Not Found'));;
        }
        if ($request->qrcode != $result->data[0]->qrcode) {
            $result = json_decode($this->productRepository->findByQr($request->qrcode));
            if (isset($result->status) != 404) {
                return json_encode(array('status' => 409, 'response' => 'Product Already Excist'));
            }
        }
        try {
            Database::beginTransaction();

            $product = new Product();
            $product->setId($request->id);
            $product->setQrcode($request->qrcode);
            $product->setName($request->name);
            $product->setPrice($request->price);
            $product->setDiscount($request->discount);
            $product->setIsExpired($request->isExpired);
            $product->setExpiredAt($request->expiredAt);

            $this->productRepository->update($product);

            Database::commitTransaction();
            return json_encode(array('status' => 200, 'response' => "OK"));
        } catch (Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    public function softDelete(Request $request)
    {
        $result = json_decode($this->productRepository->findByQr($request->qrcode));
        if (isset($result->status) == 404 || $result->data['0']->deleted_at != null) {
            return json_encode(array('status' => 404, 'response' => "Product Not Found"));
        }
        try {
            Database::beginTransaction();

            $product = new Product();
            $product->setDeletedAt(date("Y-m-d H:i:s"));
            $product->setQrcode($request->qrcode);

            $this->productRepository->softDelete($product);

            Database::commitTransaction();
            return json_encode(array('status' => 200, 'response' => "OK"));
        } catch (Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }

    public function restore(Request $request)
    {
        $result = json_decode($this->productRepository->findByQr($request->qrcode));
        if (isset($result->status) == 404 || $result->data['0']->deleted_at == null) {
            return json_encode(array('status' => 404, 'response' => "Product Not Found"));
        }
        try {
            Database::beginTransaction();

            $product = new Product();
            $product->setDeletedAt(null);
            $product->setQrcode($request->qrcode);
            $this->productRepository->softDelete($product);

            Database::commitTransaction();
            return json_encode(array('status' => 200, 'response' => "OK"));
        } catch (Exception $e) {
            Database::rollbackTransaction();
            throw $e;
        }
    }
}
