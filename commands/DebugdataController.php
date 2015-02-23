<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\db\Expression;
use app\models\User;
use app\models\UserSalt;
use app\models\Category;
use app\models\Subforum;
use app\models\Shout;
use app\models\Topic;
use app\models\Post;

class DebugdataController extends Controller {

    public function actionCreate () {

        $categories = [
            $this->createCategory('Forumzaken', 10),
            $this->createCategory('Algemeen', 20),
            $this->createCategory('Entertainment', 30),
            $this->createCategory('Meetings', 40),
        ];

        $subfora = [
            $this->createSubforum($categories[0], 'Badkamer', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'),
            $this->createSubforum($categories[0], 'Forumzaken', 'Mauris eleifend dictum enim eu dignissim.'),
            $this->createSubforum($categories[1], 'Nieuws', 'Sed purus odio, mollis id varius eu, pharetra nec dui. Mauris ut nisl pulvinar, posuere ex vitae, malesuada lacus.'),
            $this->createSubforum($categories[1], 'Polls', 'Sed purus odio, mollis id varius eu, pharetra nec dui. Mauris ut nisl pulvinar, posuere ex vitae, malesuada lacus.'),
            $this->createSubforum($categories[1], 'Algemeen', 'Ut venenatis et dolor quis rhoncus. Integer aliquet interdum iaculis.'),
            $this->createSubforum($categories[2], 'Games', 'Vestibulum sem arcu, tincidunt a maximus vitae, commodo dignissim mi.'),
            $this->createSubforum($categories[2], 'Computers', 'Curabitur consectetur ex sed nisi auctor, a congue turpis pretium.'),
            $this->createSubforum($categories[3], 'TaZrummeetings', 'Mauris a volutpat est. In ac dui nec nibh viverra congue at sed elit.'),
        ];

        $users = [
            $this->createUser('User', 2),
            $this->createUser('SubMod', 2 | 4),
            $this->createUser('Mod', 2 | 4 | 8),
            $this->createUser('Admin', 2 | 4 | 8 | 16),
        ];
        foreach ($users as $user) {
            $this->createShout($user, 'Hello world!');
            $topics = [
                $this->createTopic($user, $subfora[0], 'Donec scelerisque'),
                $this->createTopic($user, $subfora[1], 'Integer volutpat elit vitae nunc'),
                $this->createTopic($user, $subfora[2], 'Vestibulum eu eros'),
                $this->createTopic($user, $subfora[3], 'Nunc in nulla id purus'),
                $this->createTopic($user, $subfora[4], 'Sed eu mollis nunc'),
                $this->createTopic($user, $subfora[5], 'Aenean tempus leo'),
                $this->createTopic($user, $subfora[6], 'Sodales finibus vehicula'),
                $this->createTopic($user, $subfora[7], 'Augue faucibus interdum'),
            ];
            foreach ($users as $postUser) {
                $this->createPost($postUser, $topics[0], 'Sed eu mollis nunc. Pellentesque id ornare metus. Aenean tempus leo sodales finibus vehicula. Sed ut metus mollis, lobortis ipsum in, interdum mi.');
                $this->createPost($postUser, $topics[1], 'Nullam vulputate vehicula posuere. Pellentesque facilisis consequat felis, lobortis egestas nulla finibus sit amet. Suspendisse potenti.');
                $this->createPost($postUser, $topics[2], 'Integer id commodo dui, et condimentum quam. Donec neque tellus, tempus sed aliquam vel, accumsan in enim.');
                $this->createPost($postUser, $topics[3], 'Vivamus blandit viverra nibh, sit amet tincidunt ligula pellentesque vitae. Nullam leo nibh, luctus eget consectetur vitae.');
                $this->createPost($postUser, $topics[4], 'Malesuada ut turpis. Integer at lacus ac tortor malesuada ullamcorper. Donec quam dui, malesuada in lacus commodo, aliquam ornare sem.');
                $this->createPost($postUser, $topics[5], 'Vivamus non sem eget massa blandit semper. Nunc at elit ac augue faucibus interdum blandit vel orci.');
                $this->createPost($postUser, $topics[6], 'Nullam dictum quam lorem, quis lacinia tellus sollicitudin et.');
                $this->createPost($postUser, $topics[7], 'Sed id tempor nibh. In hac habitasse platea dictumst. Praesent elementum augue vel ornare hendrerit.');
            }
        }

    }

    public function actionDestroy () {

        // Cascades into subfora, topics, posts
        $this->deleteCategory('Forumzaken');
        $this->deleteCategory('Algemeen');
        $this->deleteCategory('Entertainment');
        $this->deleteCategory('Meetings');

        // Cascades into post salt, topics, posts, shouts, post reads
        $this->deleteUser('User');
        $this->deleteUser('SubMod');
        $this->deleteUser('Mod');
        $this->deleteUser('Admin');

    }

    private function createPost ($user, $topic, $text) {

        $post = new Post();
        $post->user_id = $user->id;
        $post->topic_id = $topic->id;
        $post->text = $text;
        $post->created_on = new Expression('NOW()');
        echo ' Saving post: ' . $user->name;
        if (!$post->validate() || !$post->save()) {
            echo '  FAILED: ' . print_r($post->getErrors(), true);
            return;
        }
        else {
            echo ' OK';
        }
        echo "\n";

        $topic->last_post_id = $post->id;
        $topic->last_post_user_id = $user->id;
        $topic->last_post_on = new Expression('NOW()');
        echo ' Saving topic last post information: ' . $topic->title;
        if (!$topic->validate() || !$topic->save()) {
            echo '  FAILED: ' . print_r($topic->getErrors(), true);
            return;
        }
        else {
            echo ' OK';
        }
        echo "\n";

        $subforum = $topic->getSubforum()->one();
        $subforum->last_topic_id = $topic->id;
        echo ' Saving subforum last topic information: ' . $subforum->name;
        if (!$subforum->validate() || !$subforum->save()) {
            echo '  FAILED: ' . print_r($subforum->getErrors(), true);
            return;
        }
        else {
            echo ' OK';
        }
        echo "\n";

        return $post;

    }

    private function createTopic ($user, $subforum, $title) {

        $topic = new Topic();
        $topic->subforum_id = $subforum->id;
        $topic->user_id = $user->id;
        $topic->title = $title;
        $topic->created_on = new Expression('NOW()');
        echo ' Saving topic: ' . $title;
        if (!$topic->validate() || !$topic->save()) {
            echo '  FAILED: ' . print_r($topic->getErrors(), true);
            return;
        }
        else {
            echo ' OK';
        }
        echo "\n";

        return $topic;

    }

    private function createShout ($user, $text) {

        $shout = new Shout();
        $shout->user_id = $user->id;
        $shout->text = $text;
        $shout->created_on = new Expression('NOW()');
        echo ' Saving shout: ' . $text;
        if (!$shout->validate() || !$shout->save()) {
            echo '  FAILED: ' . print_r($shout->getErrors(), true);
            return;
        }
        else {
            echo ' OK';
        }
        echo "\n";

        return $shout;

    }

    private function createCategory ($name, $order) {

        $category = new Category();
        $category->name = $name;
        $category->order = $order;
        echo ' Saving category: ' . $name;
        if (!$category->validate() || !$category->save()) {
            echo '  FAILED: ' . print_r($category->getErrors(), true);
            return;
        }
        else {
            echo ' OK';
        }
        echo "\n";

        return $category;

    }

    private function createSubforum ($category, $name, $desc) {

        $subforum = new Subforum();
        $subforum->category_id = $category->id;
        $subforum->name = $name;
        $subforum->desc = $desc;

        echo ' Saving subforum: ' . $name;
        if (!$subforum->validate() || !$subforum->save()) {
            echo '  FAILED: ' . print_r($subforum->getErrors(), true);
            return;
        }
        else {
            echo ' OK';
        }
        echo "\n";

        return $subforum;

    }

    private function createUser ($username, $rank)
    {

        $user = new User();
        $user->name = $username;
        $user->real_name = ucwords($username);
        $user->email = 'debug_user@tazrum.local';
        $user->rank = $rank;
        $user->last_ip = '127.0.0.1';
        $user->registered_on = new Expression('NOW()');
        $user->status = 'active';
        $user->activation_code = md5(rand());

        echo ' Saving user: ' . $username;
        if (!$user->validate() || !$user->save()) {
            echo '  FAILED: ' . print_r($user->getErrors(), true);
            return;
        } else {
            echo ' OK';
        }
        echo "\n";

        $userSalt = new UserSalt();
        $userSalt->user_id = $user->id;
        $userSalt->salt = md5(time() . rand());

        echo ' Saving userSalt: ' . $username;
        if (!$userSalt->validate() || !$userSalt->save()) {
            echo '  FAILED: ' . print_r($userSalt->getErrors(), true);
        } else {
            echo ' OK';
        }
        echo "\n";

        $user->password = md5($username . $userSalt->salt);

        echo ' Saving user password: ' . $username;
        if (!$user->validate() || !$user->save()) {
            echo '  FAILED: ' . print_r($user->getErrors(), true);
        } else {
            echo ' OK';
        }
        echo "\n";

        return $user;

    }

    private function deleteUser ($username) {

        $user = User::findOne(['name' => $username]);

        echo ' Deleting user: ' . $username;
        if ($user === NULL || !$user->delete()) {
            echo '  FAILED';
        }
        else {
            echo ' OK';
        }
        echo "\n";

    }

    private function deleteCategory ($name) {

        $category = Category::findOne(['name' => $name]);

        echo ' Deleting category: ' . $name;
        if ($category === NULL || !$category->delete()) {
            echo '  FAILED';
        }
        else {
            echo ' OK';
        }
        echo "\n";

    }

}