<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class V20220128094317 extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $table  = $this->table('users');
        $table->addColumn('email','string')
            ->addColumn('password', 'string')
            ->addTimestamps()
            ->create();
        $table->save();

        $table = $this->table('posts');
        $table->addColumn('name', 'string')
            ->addColumn('content', 'text')
            ->addColumn('posted', 'integer')
            ->create();
        $table->save();
    }
}
