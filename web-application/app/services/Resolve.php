<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 19-9-2017
 * Time: 21:45
 */

namespace app\services;

class Resolve {
    
    /**
     * @param       $class
     * @param null  $method
     * @param array $params
     *
     * @return mixed|object
     */
    public function resolve($class, $method = null, $params = [])
    {
        
        //Resolve model
        $reflector = new \ReflectionClass($class);
        
        $this->isInstantiable( $reflector );
        
        $constructor = $reflector->getConstructor();
        
        if( is_null( $constructor ) ) {
            return new $class;
        }
        
        $classParameters = $constructor->getParameters();
        $dependencies = $this->getDependencies( $classParameters );
        $class = $reflector->newInstanceArgs( $dependencies );
        
        if( $method != null ) {
            
            $method = $reflector->getMethod( $method );
            $methodParameters = $method->getParameters();
            $methodDependencies = $this->getDependencies( $methodParameters );
            
            //Insert static parameters
            if( !empty( $params ) ) {
                $methodDependencies[] = $params;
            }
            
            return $method->invokeArgs( $class, $methodDependencies );
            
        }
        
        return $class;
        
    }
    
    /**
     * @param \ReflectionClass $reflector
     *
     * @return bool|\Exception
     */
    public function isInstantiable( \ReflectionClass $reflector ) {
        return ( $reflector->isInstantiable() ) ? true : new \Exception('[' . $reflector->getName() . '] is not instantiable' );
    }
    
    /**
     * @param $parameters \ReflectionParameter[]
     *
     * @return array
     */
    public function getDependencies( $parameters )
    {
        $dependencies = [];
        
        foreach( $parameters as $parameter )
        {
            $dependency = $parameter->getClass();
            
            if( !is_null( $dependency ) ) {
                $dependencies[] = $this->resolve( $dependency->name );
            }
        }
        
        return $dependencies;
    }
    
}