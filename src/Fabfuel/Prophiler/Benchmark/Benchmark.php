<?php
/**
 * @author @fabfuel <fabian@fabfuel.de>
 * @created 13.11.14, 08:11
 */
namespace Fabfuel\Prophiler\Benchmark;

/**
 * Class Benchmark
 * @package Fabfuel\Prophiler\Benchmark
 */
class Benchmark implements BenchmarkInterface
{
    /**
     * @var string Unique identifier
     */
    public $name;

    /**
     * @var double Starting time
     */
    public $startTime = 0.0;

    /**
     * @var double Starting memory usage
     */
    public $startMemory = 0.0;

    /**
     * @var double Ending time
     */
    public $endTime = 0.0;

    /**
     * @var double Ending memory usage
     */
    public $endMemory = 0.0;

    /**
     * @var array Custom metadata regarding this benchmark
     */
    public $metadata = [];

    /**
     * @var string
     */
    public $component;

    /**
     * @param string $name Unique identifier like e.g. Class::Method (\Foobar\MyClass::doSomething)
     * @param array $metadata Additional metadata
     * @param string $component Name of the component which triggered the benchmark, e.g. "App", "Database"
     */
    public function __construct($name, array $metadata = [], $component = null)
    {
        $this->setName($name);
        $this->addMetadata($metadata);
        $this->setComponent($component);
    }

    /**
     * Start the benchmark
     *
     * @return void
     */
    public function start()
    {
        $this->startTime = (double) microtime(true);
        $this->startMemory = (double) memory_get_usage();
    }

    /**
     * Stop the benchmark
     *
     * @return void
     */
    public function stop()
    {
        $this->endTime = (double) microtime(true);
        $this->endMemory = (double) memory_get_usage();
    }

    /**
     * @return double Timestamp in microtime
     */
    public function getDuration()
    {
        return $this->getEndTime() - $this->getStartTime();
    }

    /**
     * @return double Timestamp in microtime
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * @return double Timestamp in microtime
     */
    public function getEndTime()
    {
        if ($this->endTime < $this->startTime) {
            $this->endTime = (double) microtime(true);
        }
        return $this->endTime;
    }

    /**
     * Memory usage (difference between start and end memory usage)
     *
     * @return double
     */
    public function getMemoryUsage()
    {
        return $this->getMemoryUsageEnd() - $this->getMemoryUsageStart();
    }

    /**
     * Memory usage (difference between start and end memory usage)
     *
     * @return double
     */
    public function getMemoryUsageStart()
    {
        return $this->startMemory;
    }

    /**
     * Memory usage (difference between start and end memory usage)
     *
     * @return double
     */
    public function getMemoryUsageEnd()
    {
        if ($this->endMemory < $this->startMemory) {
            $this->endMemory = (double) memory_get_usage();
        }
        return $this->endMemory;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return array
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * Add interesting metadata to the benchmark
     *
     * @param array $metadata Additional metadata
     */
    public function addMetadata(array $metadata)
    {
        $this->metadata = array_merge($this->metadata, $metadata);
    }

    /**
     * @return string
     */
    public function getComponent()
    {
        return $this->component;
    }

    /**
     * @param string $component
     */
        public function setComponent($component)
    {
        $this->component = $component;
    }
}
