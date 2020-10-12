@setup

	$user = 'root';

	$timezone = 'Europe/Moscow';


	$path = '/var/www/html';

	$path_storage = '/var/www/html/stor';

	$current = $path . '/current';

	$repo = "https://github.com/mavrin88/CRM";

	$branch = 'master';

	$chmods = [
		'storage/logs'
	];

	$date = new DateTime('now', new DateTimeZone($timezone));
	$release = $path .'/releases/'. $date->format('d.m.Y_H:i:s');

@endsetup

@servers(['production' => 'root@62.109.26.106'])

	@task('clone', ['on' => $on])
	mkdir -p {{ $release }}

	git clone --depth 1 -b {{ $branch }} "{{ $repo }}" {{ $release }}

	echo "#1 - Repository has been cloned"
@endtask



@task('composer', ['on' => $on])
	composer self-update

	cd {{ $release }}

	composer install --no-interaction --no-dev --prefer-dist

	echo "#2 - Composer dependencies have been instalied"
@endtask


@task('artisan', ['on' => $on])
	cd {{ $release }}

	ln -nfs {{ $path }}/.env .env;
	chgrp -h www-data .env;

	php artisan config:clear

	php artisan migrate
{{--    php artisan db:seed --class=Steps--}}
	php artisan clear-compiled --env=production;
	php artisan optimize --env=production;
	php artisan storage:link

	echo "#3 - Production dependencies have been instalied "
@endtask


@task('chmod', ['on' => $on])

	chgrp -R www-data {{ $release }};
	chmod -R ug+rwx {{ $release }};

	@foreach($chmods as $file)
	chmod -R 775 {{ $release }}/{{ $file }}

	chown -R {{ $user }}:www-data {{ $release }}/{{ $file }}

	echo "Permisions have been set for {{ $file }}"
	@endforeach
	echo "#4 - Permissions has been set"
@endtask

@task('update_symlinks')
	ln -nfs {{ $path_storage }} {{ $current }};
	chgrp -h www-data {{ $current }};

	echo "#5 - Symlink has been set"
@endtask

@task('npm')
    echo "#6 - Start npm section"
        cd {{ $release }}
        npm install -D babel-loader @babel/core @babel/preset-env webpack
        npm run production
    echo "#6 - End npm section"
@endtask

@macro('deploy', ['on' => 'production'])
	clone
	composer
	artisan
	chmod
	update_symlinks
    npm
@endmacro






