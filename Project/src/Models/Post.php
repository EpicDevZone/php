<?php

namespace App\Models;

use App\Core\Database;

class Post
{
    //! Store the post text when a Post object is created.
    public string $post;

    public function __construct(string $post)
    {
        $this->post = $post;
    }

    //! Save a new post for the logged-in user.
    public static function create(int $userId, string $content): bool
    {
        //? Change this INSERT query if the teacher changes the posts table columns.
        $statement = Database::getInstance()->getConnection()->prepare(
            'INSERT INTO posts (user_id, content) VALUES (:user_id, :content)'
        );

        //? Prepared values keep user content separate from the SQL command.
        return $statement->execute([
            'user_id' => $userId,
            'content' => trim($content),
        ]);
    }

    //! Fetch only the posts owned by the requested user.
    public static function forUser(int $userId): array
    {
        //? Keep the selected columns in sync with the posts table.
        $statement = Database::getInstance()->getConnection()->prepare(
            'SELECT id, content, created_at FROM posts WHERE user_id = :user_id ORDER BY created_at DESC'
        );
        $statement->execute(['user_id' => $userId]);

        return $statement->fetchAll();
    }

    //! fetch the post for all the users to see
    public static function forEveryone(): array
    {
        //? Keep the selected columns in sync with the posts table.
        $statement = Database::getInstance()->getConnection()->prepare(
            'SELECT * FROM posts '
        );
        $statement->execute();

        return $statement->fetchAll();
    }

    //! Update a post only when its ID and owner match.
    public static function update(int $postId, int $userId, string $content): bool
    {
        //? The user_id condition prevents one user from editing another user's post.
        $statement = Database::getInstance()->getConnection()->prepare(
            'UPDATE posts SET content = :content WHERE id = :id AND user_id = :user_id'
        );

        return $statement->execute([
            'content' => trim($content),
            'id' => $postId,
            'user_id' => $userId,
        ]);
    }

    //! Delete a post only when it belongs to the requested user.
    public static function delete(int $postId, int $userId): bool
    {
        //? Change this DELETE query if the teacher changes the post ownership column.
        $statement = Database::getInstance()->getConnection()->prepare(
            'DELETE FROM posts WHERE id = :id AND user_id = :user_id'
        );

        return $statement->execute([
            'id' => $postId,
            'user_id' => $userId,
        ]);
    }
}
