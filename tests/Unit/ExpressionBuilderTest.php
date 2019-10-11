<?php

namespace Sphinx\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sphinx\Expression\ExpressionBuilder;
use Sphinx\Expression\GroupExpression;

class ExpressionBuilderTest extends TestCase
{
    /**
     * @var ExpressionBuilder
     */
    public $eb;

    public function setUp()
    {
        $this->eb = new ExpressionBuilder();
    }

    public function testPhrase()
    {
        $this->assertInstanceOf('Sphinx\Expression\PhraseExpression', $this->eb->phrase());
    }

    public function testExclude()
    {
        $this->assertInstanceOf('Sphinx\Expression\ExcludeExpression', $this->eb->exclude());
        $this->assertEquals('!body', (string) $this->eb->exclude('body'));
        $this->assertEquals('!(body,name)', (string) $this->eb->exclude('body', 'name'));
    }

    public function testComposite()
    {
        $this->assertInstanceOf('Sphinx\Expression\CompositeExpression', $this->eb->comp());
        $this->assertEquals('expr1 expr2 expr3', $this->eb->comp('expr1', 'expr2', 'expr3'));
    }

    public function testExactOrder()
    {
        $this->assertInstanceOf('Sphinx\Expression\ExactOrderExpression', $this->eb->exact());
        $this->assertEquals('expr1 << expr2 << expr3', $this->eb->exact('expr1', 'expr2', 'expr3'));
    }

    public function testGroup()
    {
        $this->assertInstanceOf('Sphinx\Expression\GroupExpression', $this->eb->group());
        $this->assertEquals('(hello|world)', (string) $this->eb->group('hello', 'world', GroupExpression::TYPE_OR));
        $this->assertEquals('(hello&world)', (string) $this->eb->group('hello', 'world', GroupExpression::TYPE_AND));
    }

    public function testProximity()
    {
        $this->assertInstanceOf('Sphinx\Expression\ProximityExpression', $this->eb->proximity());
        $this->assertEquals('"hello world"~3', $this->eb->proximity('hello world', 3));
    }

    public function testQuorum()
    {
        $this->assertInstanceOf('Sphinx\Expression\QuorumExpression', $this->eb->quorum());
        $this->assertEquals('"hello world"/3', $this->eb->quorum('hello world', 3));
    }

    public function testField()
    {
        $this->assertInstanceOf('Sphinx\Expression\FieldExpression', $this->eb->field('body'));
        $this->assertEquals('@!body[10]', $this->eb->field('body', 10, true));
    }

    public function testWildCard()
    {
        $this->assertInstanceOf('Sphinx\Expression\WildcardExpression', $this->eb->wd());
        $this->assertInstanceOf('Sphinx\Expression\WildcardExpression', $this->eb->lwd());
        $this->assertInstanceOf('Sphinx\Expression\WildcardExpression', $this->eb->rwd());

        $this->assertEquals('*hello*', $this->eb->wd('hello'));
        $this->assertEquals('*hello', $this->eb->lwd('hello'));
        $this->assertEquals('hello*', $this->eb->rwd('hello'));
    }

    public function testTermsAndFields()
    {
        $query1 = $this->eb->search('hello')->getQuery();
        $query2 = $this->eb->search('hello')->in('field1')->getQuery();
        $query3 = $this->eb->search('hello')->in('field1')->enableRelaxedMode()->getQuery();

        $this->assertEquals('hello', (string) $query1);
        $this->assertEquals('@field1 hello', (string) $query2);
        $this->assertEquals('@@relaxed @field1 hello', (string) $query3);
    }

    public function testResetQuery()
    {
        $eb = $this->eb->search('hello');

        $this->assertEquals('hello', (string) $eb->getQuery(false));
        $this->assertEquals('hello', (string) $eb->getQuery());

        $eb1 = $this->eb->search('hello');

        $this->assertEquals('hello', (string) $eb1->getQuery());
        $this->assertEquals('', (string) $eb1->getQuery());
    }

    public function testIndex()
    {
        $query = $this->eb->index('index1')->getQuery();

        $this->assertEquals(['index1'], $query->getIndex());

        $query = $this->eb->index('index1', 'index2', 'index3')->getQuery();

        $this->assertEquals(['index1', 'index2', 'index3'], $query->getIndex());
    }
}