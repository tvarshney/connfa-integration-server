<?php

class SessionsCest extends BaseCest
{
    public function _before(ApiTester $I)
    {
        parent::_before($I);
    }

    public function _after(ApiTester $I)
    {
        parent::_after($I);
    }
    // tests
    public function tryToGetSessionsWhenEmpty(ApiTester $I)
    {
        $I->sendGET('v2/getSessions');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([]);
    }

    public function tryToGetSession(ApiTester $I)
    {
        $event = $I->haveAnEvent(['name' => 'test', 'event_type' => 'program']);
        $I->sendGET('v2/getSessions');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['date' => $event->date]);
        $I->seeResponseContainsJson(['name' => 'test']);
    }

    public function tryToGetSessionWithIfModifiedSince(ApiTester $I)
    {
        $since = \Carbon\Carbon::parse('-1 hour');
        $event = $I->haveAnEvent(['name' => 'test', 'event_type' => 'program']);
        $I->haveHttpHeader('If-modified-since', $since->toIso8601String());
        $I->sendGET('v2/getSessions');
        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson(['name' => 'test']);
    }

    public function tryToGetSessionWithFeatureIfModifiedSince(ApiTester $I)
    {
        $since = \Carbon\Carbon::parse('+5 hour');
        $I->haveAnEvent(['name' => 'test', 'event_type' => 'program']);
        $I->haveHttpHeader('If-modified-since', $since->toIso8601String());
        $I->sendGET('v2/getSessions');
        $I->seeResponseCodeIs(304);
    }
}
