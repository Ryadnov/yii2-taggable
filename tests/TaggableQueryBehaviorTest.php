<?php
/**
 * @link https://github.com/creocoder/yii2-taggable
 * @copyright Copyright (c) 2015 Alexander Kochetov
 * @license http://opensource.org/licenses/BSD-3-Clause
 */

namespace tests;

use tests\models\Post;
use Yii;
use yii\db\Connection;

/**
 * TaggableQueryBehaviorTest
 */
class TaggableQueryBehaviorTest extends DatabaseTestCase
{
    public function testFindPostsAnyTagNames()
    {
        $data = [];
        $models = Post::find()->with('tags')->anyTagNames('tag1, tag1, , tag2')->all();

        foreach ($models as $model) {
            $data[] = $model->toArray([], ['tags']);
        }

        $this->assertEquals(require(__DIR__ . '/data/test-find-posts-any-tag-names.php'), $data);
    }

    public function testFindPostsAnyTagNamesAsArray()
    {
        $data = [];
        $models = Post::find()->with('tags')->anyTagNames(['tag1', 'tag1', '', 'tag2'])->all();

        foreach ($models as $model) {
            $data[] = $model->toArray([], ['tags']);
        }

        $this->assertEquals(require(__DIR__ . '/data/test-find-posts-any-tag-names.php'), $data);
    }

    public function testFindPostsAllTagNames()
    {
        $data = [];
        $models = Post::find()->with('tags')->allTagNames('tag3, tag3, , tag4')->all();

        foreach ($models as $model) {
            $data[] = $model->toArray([], ['tags']);
        }

        $this->assertEquals(require(__DIR__ . '/data/test-find-posts-all-tag-names.php'), $data);
    }

    public function testFindPostsAllTagNamesAsArray()
    {
        $data = [];
        $models = Post::find()->with('tags')->allTagNames(['tag3', 'tag3', '', 'tag4'])->all();

        foreach ($models as $model) {
            $data[] = $model->toArray([], ['tags']);
        }

        $this->assertEquals(require(__DIR__ . '/data/test-find-posts-all-tag-names.php'), $data);
    }

    public function testFindPostsRelatedByTagNames()
    {
        $data = [];
        $models = Post::find()->with('tags')->relatedByTagNames('tag3, tag3, tag4, , tag5')->all();

        foreach ($models as $model) {
            $data[] = $model->toArray([], ['tags']);
        }

        $this->assertEquals(require(__DIR__ . '/data/test-find-posts-related-by-tag-names.php'), $data);
    }

    public function testFindPostsRelatedByTagNamesAsArray()
    {
        $data = [];
        $models = Post::find()->with('tags')->relatedByTagNames(['tag3', 'tag3', 'tag4', '', 'tag5'])->all();

        foreach ($models as $model) {
            $data[] = $model->toArray([], ['tags']);
        }

        $this->assertEquals(require(__DIR__ . '/data/test-find-posts-related-by-tag-names.php'), $data);
    }

    /**
     * @inheritdoc
     */
    public static function setUpBeforeClass()
    {
        try {
            Yii::$app->set('db', [
                'class' => Connection::className(),
                'dsn' => 'sqlite::memory:',
            ]);

            Yii::$app->getDb()->open();
            $lines = explode(';', file_get_contents(__DIR__ . '/migrations/sqlite.sql'));

            foreach ($lines as $line) {
                if (trim($line) !== '') {
                    Yii::$app->getDb()->pdo->exec($line);
                }
            }
        } catch (\Exception $e) {
            Yii::$app->clear('db');
        }
    }
}
