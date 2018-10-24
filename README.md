# Digital Marketing Group Leaderboard

This is the leaderboard public information screen application that is used at OpenText's trade shows, and Enterprise World events.

# SET UP DEVELOPMENT ENVIRONMENT

To start development on this application:

1. Clone this repository
1. Run `composer install`
1. Edit the .env file to include credentials for your local mysql install
1. Run `php artisan key:generate`
1. Run `php artisan migrate`

To run this application we recomend using Valet if you are on a Mac. Otherwise use either Homestead or Laradock.

## Valet

Installing Valet: [https://laravel.com/docs/5.5/valet](https://laravel.com/docs/5.5/valet).

## Homestead

If you are already using Homestead, you can simply integrate this repository into your current Homestead environment.

Alternatively, if you are new to Homestead, or you prefer to use site specific instances, Homestead has already been configured here. Just run `vagrant up` and you should be good to go.

### after.sh

The database migration takes place in `after.sh`. This is where we can run any scripts against the Homestead instance.

### SSH

To shell into your Homestead instance, use `vagrant ssh`.

## Docker

From the application root run `docker-compose up -d`

This will run nginx, php7, mysql8 and Mailhog.

# DEPLOY TO PRODUCTION

This is assumed to be installed on Laravel Forge.

The installation directory will be referred to as `INSTALLDIR`

1. Clone from the git project to `INSTALLDIR` on the host machine.
1. Copy env.example file to .env in `INSTALLDIR`.
1. Run `php INSTALLDIR/artisan key:generate`
1. Edit the .env file to with your custom settings.
1. [OPTIONAL] run `php INSTALLDIR/artisan migrate`
1. [OPTIONAL] run `php INSTALLDIR/artisan db:seed`
1. Ensure `php INSTALLDIR/artisan ot-appworks:fetch-events` runs without error.
1. Ensure `php INSTALLDIR/artisan ot-appworks:fetch-event-data` runs without error.
1. Ensure `php INSTALLDIR/artisan ot-scoreboard:fetch-new-points` runs without error.
1. Ensure `php INSTALLDIR/artisan ot-socialcards:fetch-new-posts` runs without error.
1. Ensure `php INSTALLDIR/artisan ot-socialcards:fetch-new-tweets` runs without error.
1. Configure scheduled tasks in `cron`, see below for details.

## CRON

There are some schedule tasks that use the Laravel Scheduler. The Laravel Scheduler needs to be triggered by `cron`.

In Forge, add a new cron task with:

    php INSTALLDIR/artisan schedule:run


## Configuring a New Event

Events will be listed on the `/home` screen of the application. Click the **Administer** button to open the event for administration.

### Initial Tasks

Currently, there are several manual tasks that must be done when a new event first enters the system.

#### Configure Teams

1. Click the **Games** menu.
1. Click the **Configure Teams** menu item.
1. In the **Configure Teams** screen, if the list of teams is empty, then click the **Reset Teams** button.
    * **WARNING!** This will destroy any previously configured teams for this event.
1. As of the current time, the configured teams use the team names as provided by AppWorks.
    * If necessary, the team names and other details can be edited to match what AppWorks provides.
    * The displayed team name will appear on the social wall, and possibly on the touch screens.

#### Configure Social Cards

TBD

#### Configure Hashtags

TBD

#### Configure Social Wall

reset social wall

#### Configure Announcements

For the announcement screen on the social wall to display an announcement, at least one announcement must be set up.

1. Click the **Social Wall** menu.
1. Click the **Configure Announcements** menu item.
1. Click the **Add New Announcement** button.
1. Enter the announcement message, and click **Submit**.
1. Activate the announcement that neeeds to be displayed.
1. The first active announcement will be the only one used if there are multiple active announcements.
1. Deactivate all announcements to hide them completely; in this case, the announcement screen will be skipped by the social wall.

#### Configure Countdown

1. Click the **Social Wall** menu.
1. Click the **Configure Countdown** menu item.
1. Set a title, the target date, and the target time, then click the **Save Updates** button.
1. The countdown may be optionally disabled.

If the countdown is enabled, then it will be used by the countdown screen on the social wall.

No special action happens when the countdown reaches zero. The social wall must be manually switched to a more sensible state by the administrator.

## Administration of Running Event

There are a number of tasks that must be carried out by the administrator as the event progresses, such as approving tweets, featuring tweets and posts, awarding points, uploading prize screens, and so on.

### Public Screen URLs

The URLs for the current event can be found under the **Dashboard** menu.

To open the social wall screen:

1. Click the **Dashboard** menu.
1. Click the **Open Social Wall** menu item.
1. A new browser tab or window will open with the social wall displayed.
1. Make a note of the URL, this can be entered into all display screens that need to show the social wall.

To open the touch screen:

1. Click the **Dashboard** menu.
1. Click the **Open Touch Screen** menu item.
1. A new browser tab or window will open with the touch screen displayed.
1. Make a note of the URL, this can be entered into all tablets that need to show the social wall.

### Reloading Screens

If new code is deployed, or if there is a change in configuration that cannot be automatically handled by the social wall screens and the touch screens, then the social wall screens and the touch screens can be commanded to reload themselves.

Only do this if absolutely necessary, as it may intefere with somebody currently using a touch screen. For the social wall screens, have a member of the event stuff do a visual check of each screen.

It is useful to have a Chrome window with each of the social wall screens and touch screens open, to verify that the action works as expected. You should see the screen reload automatically.

To reload all screens for this event that are displaying the social wall:

1. Click the **Dashboard** menu.
1. Click the **Reload Social Wall Screens** menu item.
1. All of the social wall screens will receive the command to reload a few seconds later.
1. Verify that the screens have reloaded.

To reload all tablets for this event that are displaying the touch screens:

1. Click the **Dashboard** menu.
1. Click the **Reload Touch Screens** menu item.
1. All of the touch screens will receive the command to reload a few seconds later.
1. Verify that the screens have reloaded.

### AppWorks Posts Dashboard

The AppWorks Posts are automatically approved for display on the social wall.

The dashboard is for monitoring what is being posted, and can be used to reject or feature specific posts.

To view the posts dashboard:

1. Click the **Social Media** menu.
1. Click the **Posts Dashboard** menu item.

Use the buttons under the **Controls** column to feature or reject posts. Only the most recent n posts will be featured on the social wall.

### Tweets Dashboard

The Tweets are initially unapproved. For them to be displayed on the social wall, they must be first approved by the administrator. This is to prevent inappropriate material from being posted automatically.

The dashboard is for monitoring what is being tweeted, and can be used to approve and/or feature specific tweets.

To view the tweets dashboard:

1. Click the **Social Media** menu.
1. Click the **Tweets Dashboard** menu item.

Use the buttons under the **Controls** column to feature, approve, or reject tweets. Only the most recent n tweets will be featured on the social wall.

### Points dashboard

TBD

### Award Points

TBD
