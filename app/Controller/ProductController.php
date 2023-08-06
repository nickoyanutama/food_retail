<?php

namespace FoodRetail\Controller;

use FoodRetail\Config\Database;
use FoodRetail\Model\Request;
use FoodRetail\Service\ProductService;
use FoodRetail\Repository\ProductRepository;

header('Content-Type: application/json');

/**
 * @OA\Info(title="Food Retail Api", version="0.1")
 */
class ProductController
{
    private ProductService $productService;

    public function __construct()
    {
        $connection = Database::getConnection();
        $productRepository = new ProductRepository($connection);
        $this->productService = new ProductService($productRepository);
    }

    /**
     * @OA\Get(
     *     path="/api/product",
     *     summary="Get All Product",
     *     tags={"Product"},
     *     @OA\Parameter( 
     *          name="page",
     *          in="query",
     *          required=true,
     *          description="for control pagel"
     *     ),
     *     @OA\Response(response="200", description="Get Product Success"),
     *     @OA\Response(response="404", description="Product Not Found"),
     * )
     */
    public function index()
    {
        $activePage = (isset($_GET['page'])) ? $_GET["page"] : 1;
        $limitData = 2;
        $data = $this->productService->index($activePage, $limitData);
        echo $data;
    }

    /**
     * @OA\Get(
     *     path="/api/product/show",
     *     summary="Get Specified Product",
     *     tags={"Product"},
     *     @OA\Parameter( 
     *          name="qrcode",
     *          in="query",
     *          required=true,
     *          description="insert qrcode product"
     *     ),
     *     @OA\Response(response="200", description="Get Product Success"),
     *     @OA\Response(response="404", description="Product Not Found"),
     * )
     */
    public function show()
    {
        if (isset($_GET['qrcode'])) {
            $data = $this->productService->show($_GET['qrcode']);
            echo $data;
        }
    }

    /**
     * @OA\Post(
     *     path="/api/product/create",
     *     summary="Create Product",
     *     tags={"Product"},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="qrcode",
     *                      type="string",
     *                  ), 
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                  ), 
     *                  @OA\Property(
     *                      property="price",
     *                      type="int",
     *                  ), 
     *                  @OA\Property(
     *                      property="expired_at",
     *                      type="string",
     *                  ), 
     *              ),
     *          ),
     *     ), 
     *     @OA\Response(response="200", description="Create Product Success"),
     *     @OA\Response(response="404", description="Create Product Failed"),
     *     @OA\Response(response="409", description="Product Duplicate"),
     * )
     */
    public function create()
    {
        $request = new Request();
        $request->qrcode = $_POST['qrcode'];
        $request->name = $_POST['name'];
        $request->price = $_POST['price'];
        $request->expiredAt = $_POST['expired_at'];
        $data = $this->productService->create($request);

        echo $data;
    }

    /**
     * @OA\Put(
     *     path="/api/product/update",
     *     summary="Update Product",
     *     tags={"Product"},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="id",
     *                      type="int",
     *                  ), 
     *                  @OA\Property(
     *                      property="qrcode",
     *                      type="string",
     *                  ), 
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                  ), 
     *                  @OA\Property(
     *                      property="price",
     *                      type="int",
     *                  ), 
     *                  @OA\Property(
     *                      property="expired_at",
     *                      type="string",
     *                  ), 
     *              ),
     *          ),
     *     ), 
     *     @OA\Response(response="200", description="Update Product Success"),
     *     @OA\Response(response="404", description="Update Product Failed"),
     *     @OA\Response(response="409", description="Product Duplicate"),
     * )
     */
    public function update()
    {
        $_PUT = json_decode(file_get_contents("php://input"));
        $request = new Request();
        $request->id = $_PUT->id;
        $request->qrcode = $_PUT->qrcode;
        $request->name = $_PUT->name;
        $request->price = $_PUT->price;
        $request->expiredAt = $_PUT->expired_at;
        $data = $this->productService->update($request);
        echo $data;
    }

    /**
     * @OA\Delete(
     *     path="/api/product/delete",
     *     summary="Delete Product",
     *     tags={"Product"},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="qrcode",
     *                      type="string",
     *                  ),  
     *              ),
     *          ),
     *     ), 
     *     @OA\Response(response="200", description="Delete Product Success"),
     *     @OA\Response(response="404", description="Delete Product Failed"),
     * )
     */
    public function softDelete()
    {
        $_DELETE = json_decode(file_get_contents("php://input"));
        $request = new Request();
        $request->qrcode = $_DELETE->qrcode;
        $data = $this->productService->softDelete($request);
        echo $data;
    }

    /**
     * @OA\Put(
     *     path="/api/product/restore",
     *     summary="Restore Product",
     *     tags={"Product"},
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="json",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="qrcode",
     *                      type="string",
     *                  ),  
     *              ),
     *          ),
     *     ), 
     *     @OA\Response(response="200", description="Restore Product Success"),
     *     @OA\Response(response="404", description="Restore Product Failed"),
     * )
     */
    public function restore()
    {
        $_PUT = json_decode(file_get_contents("php://input"));
        $request = new Request();
        $request->qrcode = $_PUT->qrcode;
        $data = $this->productService->restore($request);
        echo $data;
    }
}
