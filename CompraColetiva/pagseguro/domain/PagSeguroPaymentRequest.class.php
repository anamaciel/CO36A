<?php

if (!defined('PAGSEGURO_LIBRARY')) {
    die('No direct script access allowed');
}

class PagSeguroPaymentRequest {

    private $sender;
    private $currency;
    private $items;
    private $redirectURL;
    private $extraAmount;
    private $reference;
    private $shipping;
    private $maxAge;
    private $maxUses;

    public function getSender() {
        return $this->sender;
    }

    public function setSender($name, $email = null, $areaCode = null, $number = null) {
        $param = $name;
        if (is_array($param)) {
            $this->sender = new PagSeguroSender($param);
        } elseif ($param instanceof PagSeguroSender) {
            $this->sender = $param;
        } else {
            $sender = new PagSeguroSender();
            $sender->setName($param);
            $sender->setEmail($email);
            $sender->setPhone(new PagSeguroPhone($areaCode, $number));
            $this->sender = $sender;
        }
    }

    public function setSenderName($senderName) {
        if ($this->sender == null) {
            $this->sender = new PagSeguroSender();
        }
        $this->sender->setName($senderName);
    }

    public function setSenderEmail($senderEmail) {
        if ($this->sender == null) {
            $this->sender = new PagSeguroSender();
        }
        $this->sender->setEmail($senderEmail);
    }

    public function setSenderPhone($areaCode, $number = null) {
        $param = $areaCode;
        if ($this->sender == null) {
            $this->sender = new PagSeguroSender();
        }
        if ($param instanceof PagSeguroPhone) {
            $this->sender->setPhone($param);
        } else {
            $this->sender->setPhone(new PagSeguroPhone($param, $number));
        }
    }

    public function getCurrency() {
        return $this->currency;
    }

    public function setCurrency($currency) {
        $this->currency = $currency;
    }

    public function getItems() {
        return $this->items;
    }

    public function setItems(Array $items) {
        if (is_array($items)) {
            $i = Array();
            foreach ($items as $key => $item) {
                if ($item instanceof PagSeguroItem) {
                    $i[$key] = $item;
                } else if (is_array($item)) {
                    $i[$key] = new PagSeguroItem($item);
                }
            }
            $this->items = $i;
        }
    }

    public function addItem($id, $description = null, $quantity = null, $amount = null, $weight = null, $shippingCost = null) {
        $param = $id;
        if ($this->items == null) {
            $this->items = Array();
        }
        if (is_array($param)) {
            array_push($this->items, new PagSeguroItem($param));
        } else if ($param instanceof PagSeguroItem) {
            array_push($this->items, $param);
        } else {
            $item = new PagSeguroItem();
            $item->setId($param);
            $item->setDescription($description);
            $item->setQuantity($quantity);
            $item->setAmount($amount);
            $item->setWeight($weight);
            $item->setShippingCost($shippingCost);
            array_push($this->items, $item);
        }
    }

    public function getRedirectURL() {
        return $this->redirectURL;
    }

    public function setRedirectURL($redirectURL) {
        $this->redirectURL = $redirectURL;
    }

    public function getExtraAmount() {
        return $this->extraAmount;
    }

    public function setExtraAmount($extraAmount) {
        $this->extraAmount = $extraAmount;
    }

    public function getReference() {
        return $this->reference;
    }

    public function setReference($reference) {
        $this->reference = $reference;
    }

    public function getShipping() {
        return $this->shipping;
    }

    public function setShipping($address, $type = null) {
        $param = $address;
        if ($param instanceof PagSeguroShipping) {
            $this->shipping = $param;
        } else {
            $shipping = new PagSeguroShipping();
            if (is_array($param)) {
                $shipping->setAddress(new PagSeguroAddress($param));
            } else if ($param instanceof PagSeguroAddress) {
                $shipping->setAddress($param);
            }
            if ($type) {
                if ($type instanceof PagSeguroShippingType) {
                    $shipping->setType($type);
                } else {
                    $shipping->setType(new PagSeguroShippingType($type));
                }
            }
            $this->shipping = $shipping;
        }
    }

    public function setShippingAddress($postalCode = null, $street = null, $number = null, $complement = null, $district = null, $city = null, $state = null, $country = null) {
        $param = $postalCode;
        if ($this->shipping == null) {
            $this->shipping = new PagSeguroShipping();
        }
        if (is_array($param)) {
            $this->shipping->setAddress(new PagSeguroAddress($param));
        } elseif ($param instanceof PagSeguroAddress) {
            $this->shipping->setAddress($param);
        } else {
            $address = new PagSeguroAddress();
            $address->setPostalCode($postalCode);
            $address->setStreet($street);
            $address->setNumber($number);
            $address->setComplement($complement);
            $address->setDistrict($district);
            $address->setCity($city);
            $address->setState($state);
            $address->setCountry($country);
            $this->shipping->setAddress($address);
        }
    }

    public function setShippingType($type) {
        $param = $type;
        if ($this->shipping == null) {
            $this->shipping = new PagSeguroShipping();
        }
        if ($param instanceof PagSeguroShippingType) {
            $this->shipping->setType($param);
        } else {
            $this->shipping->setType(new PagSeguroShippingType($param));
        }
    }

    public function getMaxAge() {
        return $this->maxAge;
    }

    public function setMaxAge($maxAge) {
        $this->maxAge = $maxAge;
    }

    public function getMaxUses() {
        return $this->maxUses;
    }

    public function setMaxUses($maxUses) {
        $this->maxUses = $maxUses;
    }

    public function register(PagSeguroCredentials $credentials) {
        return PagSeguroPaymentService::createCheckoutRequest($credentials, $this);
    }

    public function toString() {
        $email = $this->sender ? $this->sender->getEmail() : "null";
        return "PagSeguroPaymentRequest(Reference=" . $this->reference . ",     SenderEmail=" . $email . ")";
    }

}
?>