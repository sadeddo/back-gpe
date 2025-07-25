<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250724173905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE notifications DROP FOREIGN KEY notifications_ibfk_1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE levels_user DROP FOREIGN KEY levels_user_ibfk_1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE routes DROP FOREIGN KEY routes_ibfk_1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE routes DROP FOREIGN KEY routes_ibfk_2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE routes DROP FOREIGN KEY routes_ibfk_3
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE notifications
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE levels_user
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE routes
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE accessibility_options DROP FOREIGN KEY accessibility_options_ibfk_1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE accessibility_options CHANGE option_type option_type VARCHAR(50) NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE accessibility_options ADD CONSTRAINT FK_839460A064D218E FOREIGN KEY (location_id) REFERENCES locations (location_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE accessibility_options RENAME INDEX location_id TO IDX_839460A064D218E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE beacons CHANGE beacon_uuid beacon_uuid VARCHAR(100) NOT NULL, CHANGE identifier identifier VARCHAR(50) NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL, CHANGE latitude latitude DOUBLE PRECISION NOT NULL, CHANGE longitude longitude DOUBLE PRECISION NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE beacons RENAME INDEX location_id TO IDX_2544F0F964D218E
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX user_id ON favorites_locations
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE favorites_locations CHANGE created_at created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE favorites_locations RENAME INDEX location_id TO IDX_C837144A64D218E
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX user_id ON favorites_pois
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE favorites_pois CHANGE user_id user_id INT NOT NULL, CHANGE poi_id poi_id INT NOT NULL, CHANGE created_at created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE favorites_pois RENAME INDEX poi_id TO IDX_EF009D877EACE855
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE floors CHANGE floor_label floor_label VARCHAR(50) NOT NULL, CHANGE floor_number floor_number INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE floors RENAME INDEX location_id TO IDX_C766871264D218E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE locations CHANGE name name VARCHAR(100) NOT NULL, CHANGE address address VARCHAR(255) NOT NULL, CHANGE city city VARCHAR(50) NOT NULL, CHANGE country country VARCHAR(50) NOT NULL, CHANGE latitude latitude DOUBLE PRECISION NOT NULL, CHANGE longitude longitude DOUBLE PRECISION NOT NULL, CHANGE description description LONGTEXT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pois CHANGE name name VARCHAR(100) NOT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE type type VARCHAR(50) NOT NULL, CHANGE category category VARCHAR(50) NOT NULL, CHANGE latitude latitude DOUBLE PRECISION NOT NULL, CHANGE longitude longitude DOUBLE PRECISION NOT NULL, CHANGE is_accessible is_accessible TINYINT(1) NOT NULL, CHANGE opening_hours opening_hours VARCHAR(100) NOT NULL, CHANGE closing_soon closing_soon TINYINT(1) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pois RENAME INDEX location_id TO IDX_74C303F564D218E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pois RENAME INDEX floor_id TO IDX_74C303F5854679E2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pois RENAME INDEX beacon_id TO IDX_74C303F5F6AD5578
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles CHANGE role_name role_name VARCHAR(50) NOT NULL, CHANGE role_description role_description LONGTEXT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles RENAME INDEX role_name TO UNIQ_B63E2EC7E09C0C92
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users CHANGE username username VARCHAR(100) NOT NULL, CHANGE email email VARCHAR(100) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE profile_picture_url profile_picture_url VARCHAR(255) DEFAULT NULL, CHANGE is_active is_active TINYINT(1) NOT NULL, CHANGE created_at created_at DATETIME NOT NULL, CHANGE updated_at updated_at DATETIME NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users RENAME INDEX username TO UNIQ_1483A5E9F85E0677
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users RENAME INDEX email TO UNIQ_1483A5E9E7927C74
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles_user MODIFY id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles_user DROP FOREIGN KEY roles_user_ibfk_1
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles_user DROP FOREIGN KEY roles_user_ibfk_2
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX user_id ON roles_user
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX `primary` ON roles_user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles_user DROP id, DROP assigned_at, CHANGE user_id user_id INT NOT NULL, CHANGE role_id role_id INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles_user ADD CONSTRAINT FK_57048B30A76ED395 FOREIGN KEY (user_id) REFERENCES users (user_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles_user ADD CONSTRAINT FK_57048B30D60322AC FOREIGN KEY (role_id) REFERENCES roles (role_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles_user ADD PRIMARY KEY (user_id, role_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles_user RENAME INDEX role_id TO IDX_57048B30D60322AC
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE notifications (notification_id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, message TEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, trigger_type VARCHAR(50) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_general_ci`, trigger_id INT DEFAULT NULL, is_read TINYINT(1) DEFAULT 0, sent_at DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX user_id (user_id), PRIMARY KEY(notification_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE levels_user (user_id INT NOT NULL, level INT DEFAULT 1, xp INT DEFAULT 0, updated_at DATETIME DEFAULT CURRENT_TIMESTAMP, PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE routes (route_id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, start_beacon_id INT DEFAULT NULL, end_beacon_id INT DEFAULT NULL, steps JSON DEFAULT NULL, distance DOUBLE PRECISION DEFAULT NULL, estimated_time INT DEFAULT NULL, created_at DATETIME DEFAULT CURRENT_TIMESTAMP, INDEX end_beacon_id (end_beacon_id), INDEX start_beacon_id (start_beacon_id), INDEX user_id (user_id), PRIMARY KEY(route_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = '' 
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE notifications ADD CONSTRAINT notifications_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (user_id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE levels_user ADD CONSTRAINT levels_user_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (user_id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE routes ADD CONSTRAINT routes_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (user_id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE routes ADD CONSTRAINT routes_ibfk_2 FOREIGN KEY (start_beacon_id) REFERENCES beacons (beacon_id) ON UPDATE NO ACTION ON DELETE SET NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE routes ADD CONSTRAINT routes_ibfk_3 FOREIGN KEY (end_beacon_id) REFERENCES beacons (beacon_id) ON UPDATE NO ACTION ON DELETE SET NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pois CHANGE name name VARCHAR(100) DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE type type VARCHAR(50) DEFAULT NULL, CHANGE category category VARCHAR(50) DEFAULT NULL, CHANGE latitude latitude DOUBLE PRECISION DEFAULT NULL, CHANGE longitude longitude DOUBLE PRECISION DEFAULT NULL, CHANGE is_accessible is_accessible TINYINT(1) DEFAULT 0, CHANGE opening_hours opening_hours VARCHAR(100) DEFAULT NULL, CHANGE closing_soon closing_soon TINYINT(1) DEFAULT 0, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pois RENAME INDEX idx_74c303f5f6ad5578 TO beacon_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pois RENAME INDEX idx_74c303f5854679e2 TO floor_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pois RENAME INDEX idx_74c303f564d218e TO location_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE accessibility_options DROP FOREIGN KEY FK_839460A064D218E
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE accessibility_options CHANGE option_type option_type VARCHAR(50) DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE accessibility_options ADD CONSTRAINT accessibility_options_ibfk_1 FOREIGN KEY (location_id) REFERENCES locations (location_id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE accessibility_options RENAME INDEX idx_839460a064d218e TO location_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE locations CHANGE name name VARCHAR(100) DEFAULT NULL, CHANGE address address VARCHAR(255) DEFAULT NULL, CHANGE city city VARCHAR(50) DEFAULT NULL, CHANGE country country VARCHAR(50) DEFAULT NULL, CHANGE latitude latitude DOUBLE PRECISION DEFAULT NULL, CHANGE longitude longitude DOUBLE PRECISION DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE beacons CHANGE beacon_uuid beacon_uuid VARCHAR(100) DEFAULT NULL, CHANGE identifier identifier VARCHAR(50) DEFAULT NULL, CHANGE description description TEXT DEFAULT NULL, CHANGE latitude latitude DOUBLE PRECISION DEFAULT NULL, CHANGE longitude longitude DOUBLE PRECISION DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE beacons RENAME INDEX idx_2544f0f964d218e TO location_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles CHANGE role_name role_name VARCHAR(50) DEFAULT NULL, CHANGE role_description role_description TEXT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles RENAME INDEX uniq_b63e2ec7e09c0c92 TO role_name
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users CHANGE username username VARCHAR(100) DEFAULT NULL, CHANGE email email VARCHAR(100) DEFAULT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE profile_picture_url profile_picture_url LONGTEXT DEFAULT NULL, CHANGE is_active is_active TINYINT(1) DEFAULT 1, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE updated_at updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users RENAME INDEX uniq_1483a5e9f85e0677 TO username
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE users RENAME INDEX uniq_1483a5e9e7927c74 TO email
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles_user DROP FOREIGN KEY FK_57048B30A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles_user DROP FOREIGN KEY FK_57048B30D60322AC
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles_user ADD id INT AUTO_INCREMENT NOT NULL, ADD assigned_at DATETIME DEFAULT CURRENT_TIMESTAMP, CHANGE user_id user_id INT DEFAULT NULL, CHANGE role_id role_id INT DEFAULT NULL, DROP PRIMARY KEY, ADD PRIMARY KEY (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles_user ADD CONSTRAINT roles_user_ibfk_1 FOREIGN KEY (user_id) REFERENCES users (user_id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles_user ADD CONSTRAINT roles_user_ibfk_2 FOREIGN KEY (role_id) REFERENCES roles (role_id) ON UPDATE NO ACTION ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX user_id ON roles_user (user_id, role_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE roles_user RENAME INDEX idx_57048b30d60322ac TO role_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE floors CHANGE floor_label floor_label VARCHAR(50) DEFAULT NULL, CHANGE floor_number floor_number INT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE floors RENAME INDEX idx_c766871264d218e TO location_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE favorites_pois CHANGE user_id user_id INT DEFAULT NULL, CHANGE poi_id poi_id INT DEFAULT NULL, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX user_id ON favorites_pois (user_id, poi_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE favorites_pois RENAME INDEX idx_ef009d877eace855 TO poi_id
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE favorites_locations CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        SQL);
        $this->addSql(<<<'SQL'
            CREATE UNIQUE INDEX user_id ON favorites_locations (user_id, location_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE favorites_locations RENAME INDEX idx_c837144a64d218e TO location_id
        SQL);
    }
}
