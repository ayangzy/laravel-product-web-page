<?php

namespace App\Services;

use DOMDocument;
use Carbon\Carbon;
use SimpleXMLElement;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ProductService
{

    /**
     * Handle logic to fetch products saved in the XML file
     */
    public function fetchProducts()
    {
        $xmlFile = 'product_data.xml';

        $totalValueSum = 0;
        //Check if file does not exists or the data in it is empty
        if (!file_exists($xmlFile) || filesize($xmlFile) === 0) {
            return view('products.index', compact('totalValueSum'));
        }

        //Fetch the data from the file
        $xml = simplexml_load_file('product_data.xml');
        $products = $xml->xpath('/product_data/product');

        //Fetch latest created products based on the datetime
        usort($products, function ($a, $b) {
            return strtotime($b->datetime) - strtotime($a->datetime);
        });

        return $products;
    }

    /**
     * Hand logic to upload product data to xml file
     * 
     * @param mixed $request
     * @return \SimpleXMLElement|false|null
     */
    public function storeProduct($request)
    {
        //Get the request body
        $productName = $request->input('product_name');
        $quantityInStock = $request->input('quantity_in_stock');
        $pricePerItem = $request->input('price_per_item');
        $datetime = Carbon::now()->toDateTimeString();
        $totalValue = $quantityInStock * $pricePerItem;

        $xmlFile = 'product_data.xml';

        //Check if exists
        if (!file_exists($xmlFile) || filesize($xmlFile) === 0) {
            //Create a new SimpleXML object
            $xml = new SimpleXMLElement('<product_data/>');
        } else {
            //Load the XML file
            $xml = simplexml_load_file("product_data.xml");
        }
        $productId = 0;
        $exists = false;

        //Find the ID in the existing XML data
        foreach ($xml->product as $product) {

            $recordId = (int) $product->id;
            if ($recordId > $productId) {
                $productId = $recordId;
            }

            //Check if product name is already added then return back a bad request response
            if ($product->product_name == $productName) {
                $exists = true;
                break;
            }
        }

        if ($exists) {
            throw new BadRequestException("This product is already added");
        }

        //Add data to the XML file
        $product = $xml->addChild('product');
        $product->addChild('id', $productId + 1);
        $product->addChild('product_name', $productName);
        $product->addChild('quantity_in_stock', $quantityInStock);
        $product->addChild('price_per_item', $pricePerItem);
        $product->addChild('datetime', $datetime);
        $product->addChild('total_value', $totalValue);

        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());

        //Save the changes to the XML file
        $dom->save("product_data.xml");

        return $product;
    }


    /**
     * Handle logic to update product data to xml file
     * 
     * @param mixed $request
     * @param mixed $id
     * @return mixed
     */
    public function updateProduct($request, $id)
    {
        //Get the request body
        $productName = $request->input('product_name');
        $quantityInStock = $request->input('quantity_in_stock');
        $pricePerItem = $request->input('price_per_item');
        $datetime = Carbon::now();
        $totalValue = $quantityInStock * $pricePerItem;

        //load data from the xml file
        $xml = simplexml_load_file("product_data.xml");

        $exists = false;
        //loop through the data and update based on the selected ID
        foreach ($xml->product as $product) {
            if ($product->id == $id) {
                $product->product_name =  $productName;
                $product->quantity_in_stock =  $quantityInStock;
                $product->price_per_item =  $pricePerItem;
                $product->datatime = $datetime->toDateTimeString();
                $product->total_value = $totalValue;
                break;
            }
        }

        //Save the changes to the XML file
        $xml->asXML('product_data.xml');

        return $product;
    }
}