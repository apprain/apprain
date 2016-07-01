<?php
/**
 * appRain CMF
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.opensource.org/licenses/mit-license.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@apprain.com so we can send you a copy immediately.
 *
 * @copyright  Copyright (c) 2010 appRain, Team. (http://www.apprain.org)
 * @license    http://www.opensource.org/licenses/mit-license.php MIT license
 *
 * HELP
 *
 * Official Website
 * http://www.apprain.org/
 *
 * Download Link
 * http://www.apprain.org/download
 *
 * Documents Link
 * http ://www.apprain.org/general-help-center
 */

class appRain_Base_Modules_Webservice extends appRain_Base_Objects
{
    public $serviceUrl = null;
    public $ext = ".xml";
    public $autocache = false;
    public $commonTypeList = Array('string', 'boolean', 'int', 'integer', 'float', 'double', 'FixedArray');

    /**
     * __construct()
     *
     * @param string $class_name
     * @param string $service_name
     **/
    public function __construct()
    {
    }

    /**
     * Retrun Service Url
     *
     * @return string
     */
    public function serviceUrl($short = false)
    {
        if ($short) {
            $niddles = preg_split("[_]", $this->getClassName());
            return App::Load("Helper/Config")->baseurl("/developer/webservice/{$niddles[count($niddles)-1]}/wsdl");
        }
        else {
            return App::Load("Helper/Config")->baseurl("/developer/webservice/{$this->getClassName()}/wsdl");
        }
    }

    private function wsdlCachePath()
    {
        return WSDL_CACHE_PATH . DS . $this->getClassName() . $this->ext;
    }

    /**
     * createWSDL
     *
     * @return string
     **/
    public function createWSDL()
    {
        // Raise Exception is no service available
        if (!$this->getServiceName()) {
            throw new Exception('No service name.');
        }

        $dom = new DOMDocument ('1.0');

        // Create WSDL Header
        $definition = $dom->createElement('definitions');
        $definition = $dom->appendChild($definition);

        $definition->setAttribute('xmlns:typens', "urn:{$this->getServiceName()}");
        $definition->setAttribute('xmlns:xsd', "http://www.w3.org/2001/XMLSchema");
        $definition->setAttribute('xmlns:tns', "http://example.com/stockquote.wsdl");
        $definition->setAttribute('xmlns:soap', "http://schemas.xmlsoap.org/wsdl/soap/");
        $definition->setAttribute('xmlns:soapenc', "http://schemas.xmlsoap.org/soap/encoding/");
        $definition->setAttribute('xmlns:wsdl', "http://schemas.xmlsoap.org/wsdl/");
        $definition->setAttribute('xmlns', "http://schemas.xmlsoap.org/wsdl/");
        $definition->setAttribute('name', "{$this->getServiceName()}");
        $definition->setAttribute('targetNamespace', "urn:{$this->getServiceName()}");

        $domType = $dom->importNode(app::__def()->WSDLType(), true);

        $domType = $definition->appendChild($domType);

        $domType->getElementsByTagName('schema')->item(0)->setAttribute('targetNamespace', "http://example.com/stockquote.xsd");

        $domType->getElementsByTagName('schema')->item(0)->setAttribute('xmlns', "http://www.w3.org/2000/10/XMLSchema");

        // Validated Class Name
        if (!$this->getClassName()) {
            throw new Exception('No class name.');
        }

        // Get Class Definition from Reflection API
        $class = new ReflectionClass($this->getClassName());

        // Check if the class Instantiable
        if (!$class->isInstantiable()) {
            throw new Exception('Class is not instantiable.');
        }

        $methods = $class->getMethods();

        // Create Port
        $PortType = $dom->createElement('portType');
        $PortType->setAttribute('name', "{$this->getServiceName()}_{$this->getClassName()}Port");

        // Binding
        $Binding = $dom->createElement('binding');
        $Binding->setAttribute('name', "{$this->getServiceName()}_{$this->getClassName()}Binding");
        $Binding->setAttribute('type', "tns:{$this->getServiceName()}_{$this->getClassName()}Port");

        $soap = $dom->createElement('soap:binding');
        $soap = $Binding->appendChild($soap);
        $soap->setAttribute('style', "rpc");
        $soap->setAttribute('transport', "http://schemas.xmlsoap.org/soap/http");

        // Service
        $Service = $dom->createElement('service');
        $Service->setAttribute('name', "{$this->getServiceName()}_{$this->getClassName()}");

        $documentation = $dom->createElement('documentation');
        $documentation = $Service->appendChild($documentation);

        $port = $dom->createElement('port');
        $port = $Service->appendChild($port);
        $port->setAttribute('name', "{$this->getServiceName()}_{$this->getClassName()}Port");
        $port->setAttribute('binding', "tns:{$this->getServiceName()}_{$this->getClassName()}Binding");

        $soap = $dom->createElement('soap:address');
        $soap = $port->appendChild($soap);
        $soap->setAttribute('location', $this->serviceUrl(true));

        foreach ($methods as $method) {
            if ($method->isPublic() && !$method->isConstructor()) {
                $operation = $dom->createElement('operation');
                $operation = $PortType->appendChild($operation);
                $operation->setAttribute('name', $method->getName());

                $input = $dom->createElement('input');
                $input = $operation->appendChild($input);
                $input->setAttribute('message', "tns:" . $method->getName() . "Request");

                $output = $dom->createElement('output');
                $output = $operation->appendChild($output);
                $output->setAttribute('message', "tns:" . $method->getName() . "Response");

                // Bingds
                $operation = $dom->createElement('operation');
                $operation = $Binding->appendChild($operation);
                $operation->setAttribute('name', $method->getName());

                $soap = $dom->createElement('soap:operation');
                $soap = $operation->appendChild($soap);
                $soap->setAttribute('soapAction', "urn:{$this->getServiceName()}_{$this->getClassName()}" . '#' . $this->getClassName() . '#' . $method->getName());

                $input = $dom->createElement('input');
                $input = $operation->appendChild($input);

                $soap = $dom->createElement('soap:body');
                $soap = $input->appendChild($soap);
                $soap->setAttribute('use', "encoded");
                $soap->setAttribute('namespace', "urn:{$this->getServiceName()}_{$this->getClassName()}");
                $soap->setAttribute('encodingStyle', "http://schemas.xmlsoap.org/soap/encoding/");

                $output = $dom->createElement('output');
                $output = $operation->appendChild($output);

                $soap = $dom->createElement('soap:body');
                $soap = $output->appendChild($soap);
                $soap->setAttribute('use', "encoded");
                $soap->setAttribute('namespace', "urn:{$this->getServiceName()}_{$this->getClassName()}");
                $soap->setAttribute('encodingStyle', "http://schemas.xmlsoap.org/soap/encoding/");


                $Message = $dom->createElement('message');
                $Message->setAttribute('name', $method->getName() . "Request");

                $parameters = $method->getParameters();

                $typeList = $this->getTypeList($method->getDocComment(), 'Request');

                foreach ($parameters as $parameter) {
                    $type = array_shift($typeList);

                    $part = $dom->createElement('part');
                    $part = $Message->appendChild($part);
                    $part->setAttribute('name', $parameter->getName());
                    $part->setAttribute('type', $this->getMsgType($type));
                }
                $definition->appendChild($Message);


                $returntype = $this->getTypeList($method->getDocComment(), 'Response');
                $Message = $dom->createElement('message');
                $Message->setAttribute('name', $method->getName() . "Response");

                $part = $dom->createElement('part');
                $part = $Message->appendChild($part);
                $part->setAttribute('name', $method->getName());
                $part->setAttribute('type', $this->getMsgType($returntype[0]));
                $definition->appendChild($Message);
            }
        }

        $definition->appendChild($PortType);
        $definition->appendChild($Binding);
        $definition->appendChild($Service);

        $xml = $dom->save($this->wsdlCachePath());
    }

    private function getMsgType($type = NULL)
    {
        return (in_array($type, $this->commonTypeList)) ? "xsd:{$type}" : "typens:{$type}";
    }

    private function getTypeList($comments = NULL, $Requesttype = 'Request')
    {
        $typeList = Array();

        foreach (
            explode(
                (
                (strtolower($Requesttype) == 'request')
                    ? '@param ' : '@return '
                )
                , $comments
            )
            as $key => $type
        ) {
            if ($key > 0) array_push($typeList, trim(substr($type, 0, strpos($type, ' '))));
        }

        return $typeList;
    }

    /**
     * Display WSDL Defination
     *
     */
    public function showWSDL()
    {
        $this->createWSDL();
        header('Content-type: text/xml');
        readfile($this->wsdlCachePath());
        exit;
    }

    /**
     * Load Soap Server
     *
     * @return null;
     */
    public function loadServer()
    {
        $servidorSoap = new SoapServer($this->serviceUrl());
        $servidorSoap->setClass($this->getClassName());
        $servidorSoap->handle();
        exit;
    }

    /**
     *
     * @return string
     */
    public function showWSDLURI()
    {
        $dom = new DOMDocument ('1.0');
        $ref = $dom->createElement('app:appRain');
        $ref = $dom->appendChild($ref);
        $ref->setAttribute('xmlns:app', "http://schemas.xmlsoap.org/app/");
        $ref->setAttribute('xmlns:scl', "http://schemas.xmlsoap.org/app/scl/");

        $scl = $dom->createElement('scl:contractRef');
        $scl = $ref->appendChild($scl);
        $scl->setAttribute('ref', $this->serviceUrl(true));

        header('Content-type:text/xml');
        echo $dom->saveXML();
        exit;
    }
}