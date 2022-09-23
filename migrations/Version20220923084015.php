<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220923084015 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE icon (id INT AUTO_INCREMENT NOT NULL, label LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE section (id INT AUTO_INCREMENT NOT NULL, voyage_id INT NOT NULL, icon_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, INDEX IDX_2D737AEF68C9E5AF (voyage_id), INDEX IDX_2D737AEF54B9D732 (icon_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF68C9E5AF FOREIGN KEY (voyage_id) REFERENCES voyage (id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEF54B9D732 FOREIGN KEY (icon_id) REFERENCES icon (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF68C9E5AF');
        $this->addSql('ALTER TABLE section DROP FOREIGN KEY FK_2D737AEF54B9D732');
        $this->addSql('DROP TABLE icon');
        $this->addSql('DROP TABLE section');
    }
}
