<?php

namespace FormatD\DummyResources\Aspect;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\ResourceManagement\PersistentResource;

/**
 * @Flow\Aspect
 */
class ResourceFallbackAspect {

	/**
	 * @Flow\InjectConfiguration(package="FormatD.DummyResources", path="path")
	 * @var string
	 */
	protected $dummyResourcesPath;

	/**
	 * @param \Neos\Flow\Aop\JoinPointInterface $joinPoint
	 * @Flow\Around("setting(FormatD.DummyResources.enable) && method(Neos\Flow\ResourceManagement\Storage\FileSystemStorage->getStreamByResource(.*))")
	 * @return resource|boolean The resource stream or false if the stream could not be obtained
	 */
	public function fallbackToDummyFromResource(\Neos\Flow\Aop\JoinPointInterface $joinPoint)
    {
		/**
		 * @var PersistentResource $resource
		 */
		$resource = $joinPoint->getMethodArgument('resource');

		$stream = $joinPoint->getAdviceChain()->proceed($joinPoint);

		if ($stream) {
			return $stream;
		}

		return $this->serveDummyResource($resource->getFileExtension(), 'rb');
	}


	/**
	 * @param \Neos\Flow\Aop\JoinPointInterface $joinPoint
	 * @Flow\Around("setting(FormatD.DummyResources.enable) && method(Neos\Flow\ResourceManagement\Storage\FileSystemStorage->getStreamByResourcePath(.*))")
	 * @return resource|boolean The resource stream or false if the stream could not be obtained
	 */
	public function fallbackToDummyFromPath(\Neos\Flow\Aop\JoinPointInterface $joinPoint)
    {
		/**
		 * @var string $resourcePath
		 */
		$relativePath = $joinPoint->getMethodArgument('relativePath');

		$stream = $joinPoint->getAdviceChain()->proceed($joinPoint);

		if ($stream) {
			return $stream;
		}

		return $this->serveDummyResource(pathinfo($relativePath, PATHINFO_EXTENSION), 'r');
	}

	/**
	 * @param string $fileExtension
	 * @return false|resource
	 */
	protected function serveDummyResource($fileExtension, $mode = 'r')
    {
		$pathAndFilename = $this->dummyResourcesPath . 'dummy.' . $fileExtension;
		return fopen($pathAndFilename, $mode);
	}

}
