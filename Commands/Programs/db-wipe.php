<?php

namespace Commands\Programs;

use Commands\AbstractCommand;
use Commands\Argument;


class DbWipe extends AbstractCommand
{
    // 使用するコマンド名を設定
    protected static ?string $alias = 'db-wipe';

    public static function getArguments(): array
    {
        return [
            (new Argument('db-wipe'))->description('Drop database. if option "backup" added,make bakup file with timestamp.')->required(false)->allowAsShort(true),
        ];
    }

    public function execute(): int
    {
        $backup = $this->getArgumentValue('backup');
        if($backup === false){
            $this->log("Starting db-wipe......");
            $this->migrate();
        }
        else{
            // ロールバックは設定されている場合はtrue、またはそれに添付されている値が整数として表されます。
            if($backup === true){
                printf("bakup starting....");

            }
        }

        return 0;
    }



}
