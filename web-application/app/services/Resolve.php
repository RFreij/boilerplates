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
     * @param $class
     *
     * @return object
     * @throws \Exception
     */
    public function resolve($class)
    {
        $reflector = new \ReflectionClass($class);
        
        if( !$reflector->isInstantiable() ) {
            throw new \Exception("[$class] is not instantiable" );
        }
        
        $constructor = $reflector->getConstructor();
        
        if( is_null( $constructor ) ) {
            return new $class;
        }
        
        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies( $parameters );
        
        return $reflector->newInstanceArgs( $dependencies );
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
            
            if( is_null( $dependency ) ) {
                $dependencies[] = $this->resolveNonClass( $parameter );
            } else {
                $dependencies[] = $this->resolve( $dependency->name );
            }
        }
        
        return $dependencies;
    }
    
    /**
     * @param \ReflectionParameter $parameter
     *
     * @return mixed
     * @throws \Exception
     */
    public function resolveNonClass( \ReflectionParameter $parameter )
    {
        if( $parameter->isDefaultValueAvailable() ) {
            return $parameter->getDefaultValue();
        }
        
        throw new \Exception("Cannot resolve unknown" );
    }
    
}