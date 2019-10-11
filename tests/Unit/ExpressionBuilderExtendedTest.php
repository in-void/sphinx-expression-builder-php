<?php

namespace Sphinx\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sphinx\Expression\ExpressionBuilder;
use Sphinx\Expression\FieldExpression;
use Sphinx\Expression\GroupExpression;

class ExpressionBuilderExtendedTest extends TestCase
{
    /**
     * @var ExpressionBuilder
     */
    private $qb;

    public function setUp()
    {
        $this->qb = new ExpressionBuilder();
    }

    public function testQuery1()
    {
        $this->qb
            ->search($this->qb->phrase('hello world'))
            ->search($this->qb->proximity('example program', 5))->in('title')
            ->search('python', $this->qb->exclude($this->qb->group('php', 'perl', GroupExpression::TYPE_OR)))->in('body')
            ->search('code')->in(FieldExpression::SEARCH_All);

        $this->assertEquals("\"hello world\" @title \"example program\"~5 @body python !(php|perl) @* code", $this->qb->getQuery());
    }

    public function testQuery2()
    {
        $this->qb
            ->search(
                'animal',
                $this->qb->group('cat', 'dog', 'bird', GroupExpression::TYPE_OR),
                $this->qb->group('white', $this->qb->exclude('spotted')),
                $this->qb->group('long hair', 'short hair', 'feathers', GroupExpression::TYPE_OR)
            );

        $this->assertEquals("animal (cat|dog|bird) (white !spotted) (long hair|short hair|feathers)", $this->qb->getQuery());
    }

    public function testQuery3()
    {
        $this->qb->search(
            $this->qb->exact(
                $this->qb->group('hello', 'world', 'cat'),
                $this->qb->phrase('exact phrase'),
                $this->qb->group('red', 'green', 'blue', GroupExpression::TYPE_OR)
            )
        );

        $this->assertEquals("(hello world cat) << \"exact phrase\" << (red|green|blue)", $this->qb->getQuery());
    }

    public function testQuery4()
    {
        $this->qb->search(
            'aaa', $this->qb->exclude($this->qb->group('bbb', $this->qb->exclude($this->qb->group('ccc', 'ddd'))))
        );

        $this->assertEquals("aaa !(bbb !(ccc ddd))", $this->qb->getQuery());
    }

    public function testQuery5()
    {
        $this->qb
            ->search('hello')->in('body')
            ->search('root@localhost')->in('email', 'username')
            ->search($this->qb->phrase('hello world'))->in('content', 10);

        $this->assertEquals('@body hello @(email,username) root@localhost @content[10] "hello world"', $this->qb->getQuery());
    }
}