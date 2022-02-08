migrateCreate:
	composer exec phinx -- create
lint:
	composer exec phpcs -- --standard=PSR12 config app tests public

lint-fix:
	composer exec phpcbf -- --standard=PSR12 config app tests public

