<?php

namespace OSS\CoreBundle\Tests\Entity;

use OSS\CoreBundle\Entity\Manager;
use OSS\MatchBundle\Entity\Team;

class ManagerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Manager
     */
    private $manager;

    public function setUp()
    {
        $this->manager = new Manager();
    }

    public function tearDown()
    {
        $this->manager = null;
    }

    public function testGetTeam()
    {
        $this->assertNull($this->manager->getTeam());
    }

    public function testSetAndGetTeam()
    {
        $team = new Team();
        $this->manager->setTeam($team);
        $this->assertEquals($team, $this->manager->getTeam());
        $this->assertEquals($this->manager, $team->getManager());
    }

    public function testDefensiveSkillTransferFactor()
    {
        $this->assertTransferFactorDefensiveSkill(1, Manager::PREFERRED_SKILL_NEUTRAL);
        $this->assertTransferFactorDefensiveSkill(2, Manager::PREFERRED_SKILL_DEFENSE);
        $this->assertTransferFactorDefensiveSkill(1, Manager::PREFERRED_SKILL_OFFENSE);
    }

    public function testOffensiveSkillTransferFactor()
    {
        $this->assertTransferFactorOffensiveSkill(1, Manager::PREFERRED_SKILL_NEUTRAL);
        $this->assertTransferFactorOffensiveSkill(1, Manager::PREFERRED_SKILL_DEFENSE);
        $this->assertTransferFactorOffensiveSkill(2, Manager::PREFERRED_SKILL_OFFENSE);
    }
    
    public function testDefensiveMoneyTransferFactor()
    {
        $this->assertTransferFactorMoneyBehaviour(1, Manager::MONEY_BEHAVIOUR_NEUTRAL);
        $this->assertTransferFactorMoneyBehaviour(2, Manager::MONEY_BEHAVIOUR_DEFENSIVE);
        $this->assertTransferFactorMoneyBehaviour(0.5, Manager::MONEY_BEHAVIOUR_OFFENSIVE);
    }

    public function testAcceptTransferOffer()
    {
        $manager = new Manager();
        $manager->setAcceptTransferScoreOffset(100);
        $this->assertTrue($manager->acceptTransferOffer(150));
        $this->assertTrue($manager->acceptTransferOffer(100));
        $this->assertFalse($manager->acceptTransferOffer(99));
        $this->assertFalse($manager->acceptTransferOffer(50));
    }

    public function testDenyTransferOffer()
    {
        $manager = new Manager();
        $manager->setDenyTransferScoreOffset(50);
        $this->assertTrue($manager->denyTransferOffer(25));
        $this->assertTrue($manager->denyTransferOffer(50));
        $this->assertFalse($manager->denyTransferOffer(51));
        $this->assertFalse($manager->denyTransferOffer(100));
    }

    private function assertTransferFactorDefensiveSkill($factor, $preferredSkill)
    {
        $manager = new Manager();
        $manager->setPreferredSkill($preferredSkill);
        $this->assertEquals($factor, $manager->getTransferFactorDefensiveSkill());
    }

    private function assertTransferFactorOffensiveSkill($factor, $preferredSkill)
    {
        $manager = new Manager();
        $manager->setPreferredSkill($preferredSkill);
        $this->assertEquals($factor, $manager->getTransferFactorOffensiveSkill());
    }

    private function assertTransferFactorMoneyBehaviour($factor, $moneyBehaviour)
    {
        $manager = new Manager();
        $manager->setMoneyBehaviour($moneyBehaviour);
        $this->assertEquals($factor, $manager->getTransferFactorMoneyBehaviour());
    }
}
