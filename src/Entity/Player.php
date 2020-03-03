<?php
namespace App\Entity;

class Player
{
    private const PLAY_PLAY_STATUS = 'play';
    private const BENCH_PLAY_STATUS = 'bench';

    private int $number;
    private string $name;
    private string $playStatus;
    private int $inMinute;
    private int $outMinute;
    private string $position;
    private string $card;
    private string $goals;

    public const GOALKEEPER = 'В';
    public const DEFENDER = 'З';
    public const MIDFIELDER = 'П';
    public const FORWARD = 'Н';

    public const POSITIONS = [
        self::GOALKEEPER,
        self::DEFENDER,
        self::MIDFIELDER,
        self::FORWARD
    ];

    public function __construct(int $number, string $name, string $position)
    {
        $this->number = $number;
        $this->name = $name;
        $this->playStatus = self::BENCH_PLAY_STATUS;
        $this->inMinute = 0;
        $this->outMinute = 0;
        $this->assertCorrectPosition($position);
        $this->position = $position;
        $this->goals = 0;
        $this->card = '';
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getInMinute(): int
    {
        return $this->inMinute;
    }

    public function getOutMinute(): int
    {
        return $this->outMinute;
    }

    public function isPlay(): bool
    {
        return $this->playStatus === self::PLAY_PLAY_STATUS;
    }

    public function getPlayTime(): int
    {
        if(!$this->outMinute) {
            return 0;
        }

        return $this->outMinute - $this->inMinute;
    }

    public function goToPlay(int $minute): void
    {
        $this->inMinute = $minute;
        $this->playStatus = self::PLAY_PLAY_STATUS;
    }

    public function goToBench(int $minute): void
    {
        $this->outMinute = $minute;
        $this->playStatus = self::BENCH_PLAY_STATUS;
    }

    public function getPosition(): string
    {
        return $this->position;
    }
    
    private function assertCorrectPosition(string $position): void
    {
        if (!in_array($position, self::POSITIONS, true)) {
            throw new \Exception(
                sprintf(
                    'Position "%s" is not supported. Available positions are: "%s".',
                    $position,
                    implode('", "', self::POSITIONS)
                )
            );
        }
    }

    public function setCard($card)
    {
        if($card == Match::YELLOW_CARD_MESSAGE_TYPE ) {
            if($this->card == Match::YELLOW_CARD_MESSAGE_TYPE) {
                $this->card = Match::RED_CARD_MESSAGE_TYPE;
            } else {
                $this->card = Match::YELLOW_CARD_MESSAGE_TYPE;
            }
        } else {
            $this->card = Match::RED_CARD_MESSAGE_TYPE;
        }

    }

    public function getCard(): string
    {
        if(!$this->card) {
            return '';
        }
        return $this->card;
    }

    public function addGoal()
    {
        $this->goals++;
    }

    public function getGoals(): int
    {
        if(!$this->goals) {
            return 0;
        }
        return $this->goals;
    }
}