<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * サービスの登録
     *
     * @return void
     */
    public function register()
    {
        $this->bindUserRepository();
        $this->bindSurveyRepository();
        $this->bindSurveyQuestionRepository();
    }

    /**
     * Userリポジトリインターフェースとその実装をバインドします
     *
     * @return void
     */
    protected function bindUserRepository()
    {
        $this->app->bind(
            \App\Repositories\User\UserRepositoryInterface::class,
            \App\Repositories\User\UserRepository::class
        );
    }

    /**
     * Surveyリポジトリインターフェースとその実装をバインドします
     *
     * @return void
     */
    protected function bindSurveyRepository()
    {
        $this->app->bind(
            \App\Repositories\Survey\SurveyRepositoryInterface::class,
            \App\Repositories\Survey\SurveyRepository::class
        );
    }

    /**
     * SurveyQuestionリポジトリインターフェースとその実装をバインドします
     *
     * @return void
     */
    protected function bindSurveyQuestionRepository()
    {
        $this->app->bind(
            \App\Repositories\SurveyQuestion\SurveyQuestionRepositoryInterface::class,
            \App\Repositories\SurveyQuestion\SurveyQuestionRepository::class
        );
    }
}
