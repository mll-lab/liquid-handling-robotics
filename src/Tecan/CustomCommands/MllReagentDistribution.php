<?php declare(strict_types=1);

namespace Mll\LiquidHandlingRobotics\Tecan\CustomCommands;

use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\Command;
use Mll\LiquidHandlingRobotics\Tecan\BasicCommands\ReagentDistribution;
use Mll\LiquidHandlingRobotics\Tecan\LiquidClass\LiquidClass;
use Mll\LiquidHandlingRobotics\Tecan\ReagentDistribution\ReagentDistributionDirection;

final class MllReagentDistribution extends Command
{
    public const NUMBER_OF_DITI_REUSES = 6;
    public const NUMBER_OF_MULTI_DISP = 1;

    private AspirateParameters $source;

    private DispenseParameters $target;

    private float $volume;

    private LiquidClass $liquidClass;

    public function __construct(
        AspirateParameters $source,
        DispenseParameters $target,
        float $dispenseVolume,
        LiquidClass $liquidClass
    ) {
        $this->source = $source;
        $this->target = $target;
        $this->volume = $dispenseVolume;
        $this->liquidClass = $liquidClass;
    }

    public function toString(): string
    {
        $reagentDistribution = new ReagentDistribution(
            $this->source->formatToAspirateAndDispenseParameters(),
            $this->target->formatToAspirateAndDispenseParameters(),
            $this->volume,
            $this->liquidClass,
            self::NUMBER_OF_DITI_REUSES,
            self::NUMBER_OF_MULTI_DISP,
            ReagentDistributionDirection::LEFT_TO_RIGHT(),
            $this->excludedWells(),
        );

        return $reagentDistribution->toString();
    }

    /**
     * @return array<int, int>
     */
    private function excludedWells(): array
    {
        $min = min($this->target->dispensePositions);
        $max = max($this->target->dispensePositions);
        assert(is_int($min));
        assert(is_int($max));

        $allWellsFromStartToEnd = range($min, $max);

        return array_diff($allWellsFromStartToEnd, $this->target->dispensePositions);
    }
}
