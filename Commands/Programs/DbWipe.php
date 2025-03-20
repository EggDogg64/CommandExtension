<?php

namespace Commands\Programs;

use Commands\AbstractCommand;
use Commands\Argument;
use Helpers\Settings;


class DbWipe extends AbstractCommand
{
    // 使用するコマンド名を設定
    protected static ?string $alias = 'db-wipe';

    public static function getArguments(): array
    {
        return [
            (new Argument('backup'))->description('Drop database. if option "backup" is added,make bakup-file with timestamp.')->required(false)->allowAsShort(false),
        ];
    }

    public function execute(): int
    {
        $backup = $this->getArgumentValue('backup');
        if($backup === false){
            $this->log("Starting db-wipe......");
            $this->dbwipe();
        }
        else{
            if($backup === true){
                printf("Starting backup and db-wipe ....");
                $this -> backup();
                $this -> dbwipe();

            }
        }

        return 0;
    }

    private function dbwipe(): void{
        
        $username =  Settings::env('DATABASE_USER') ; // MySQLユーザー名
        $dbname =  Settings::env('DATABASE_NAME') ;   // 削除するデータベース名
        
        // MySQLコマンドを構築
       
        $command = "mysql -u {$username} -p -e 'DROP DATABASE {$dbname}'";
        
        // コマンド実行
        exec($command, $output, $returnCode);
        
        if ($returnCode === 0) {
            echo "データベース {$dbname} を削除しました。\n";
        } else {
            echo "エラーが発生しました: " . implode("\n", $output) . "\n";
        }
        

    }

    private function backup(): void{

        $username =  Settings::env('DATABASE_USER') ; // MySQLユーザー名
        $dbname =  Settings::env('DATABASE_NAME') ;   // 削除するデータベース名

        $command = "mysqldump -u {$username} -p {$dbname} > ";
       

        $filename = sprintf(
            '%s_backup.sql',
            date('Y-m-d_H:i:s')
        );
        echo $filename ;
        printf($command . $filename . "\n");
        $command = $command . $filename;

        exec($command);
    }

}
