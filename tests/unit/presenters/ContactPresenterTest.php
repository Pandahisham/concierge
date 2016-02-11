<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Timegridio\Concierge\Presenters\ContactPresenter;

class ContactPresenterTest extends TestCaseDB
{
    use DatabaseTransactions;
    use CreateContact;

    protected $contactPresenter;

    public function setUp()
    {
        parent::setUp();

        $this->contactPresenter = $this->createContactPresenter();
    }

    /**
     * @test
     */
    public function it_has_a_presenter()
    {
        $contact = $this->createContactPresenter();

        $this->assertEquals(ContactPresenter::class, $contact->getPresenterClass());
    }

    /**
     * @test
     */
    public function it_has_full_name()
    {
        $contact = $this->createContactPresenter();

        $fullname = $contact->fullname();

        $this->assertInternalType('string', $fullname);
        $this->assertEquals("{$contact->firstname} {$contact->lastname}", $fullname);
    }

    /**
     * @test
     */
    public function it_has_profile_fulfilment_quality_score()
    {
        $contact = $this->createContactPresenter();

        $quality = $contact->quality();

        $this->assertInternalType('float', $quality);
        $this->assertGreaterThan(0, $quality);
        $this->assertLessThan(100, $quality);
    }

    /**
     * @test
     */
    public function it_has_an_age_attribute()
    {
        $contact = $this->createContactPresenter();

        $age = $contact->age();

        $this->assertInternalType('int', $age);
        $this->assertGreaterThan(0, $age);
    }

    /////////////
    // Helpers //
    /////////////

    protected function createContactPresenter($overrides = [])
    {
        return new ContactPresenter($this->createContact($overrides));
    }
}
