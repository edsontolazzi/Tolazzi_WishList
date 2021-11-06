<?php

namespace Tolazzi\WishList\Plugin;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Wishlist\Controller\Index\Add;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Controller\ResultInterface;

class WishList
{

    /** @var ProductRepositoryInterface */
    private ProductRepositoryInterface $productRepository;

    /**
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param Add $subject
     * @param $resultRedirect
     * @return ResultInterface
     * @throws NoSuchEntityException
     */
    public function afterExecute(Add $subject, $resultRedirect): ResultInterface
    {
        $params = $subject->getRequest()->getParams();
        $productId = $params['product'];
        $product = $this->productRepository->getById($productId);

        $urlKey = $product->getData('url_key');
        $resultRedirect->setPath("./$urlKey.html");
        return $resultRedirect;
    }

}
