<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220525070907 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_yeti (user_id INT NOT NULL, yeti_id INT NOT NULL, INDEX IDX_7CD31006A76ED395 (user_id), INDEX IDX_7CD310066FD936CB (yeti_id), PRIMARY KEY(user_id, yeti_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_yeti ADD CONSTRAINT FK_7CD31006A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_yeti ADD CONSTRAINT FK_7CD310066FD936CB FOREIGN KEY (yeti_id) REFERENCES yeti (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user_yeti');
    }
}
