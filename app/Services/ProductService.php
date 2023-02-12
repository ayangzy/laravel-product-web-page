<?php

namespace App\Services;

use DOMDocument;
use Carbon\Carbon;
use SimpleXMLElement;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ProductService
{

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
}