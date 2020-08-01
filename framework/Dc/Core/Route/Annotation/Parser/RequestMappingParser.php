<?php

namespace Dc\Core\Route\Annotation\Parser;


use Dc\Core\Route\Route;

/**
 * Class RequestMappingParser
 *
 * @since 2.0
 *
 * @AnnotationParser(RequestMapping::class)
 */
class RequestMappingParser
{
    /**
     * @param int            $type
     * @param RequestMapping $annotation
     *
     * @return array
     * @throws AnnotationException
     */
    public function parse($annotation):void
    {
        $routeinfo = [
            'routePath' => $annotation->getRoute(),
            'handle' => $annotation->getHandler()
        ];
        Route::addRoute($annotation->getMethod(), $routeinfo);
    }
}
