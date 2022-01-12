migrateCreate:
	composer exec phinx -- create
lint:
	composer exec phpcs -- --standard=PSR12 config src

lint-fix:
	composer exec phpcbf -- --standard=PSR12 config src

