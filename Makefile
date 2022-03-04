migrateCreate:
	composer exec phinx -- create
lint:
	composer exec phpcs -- --standard=PSR12 config app tests public

lint-fix:
	composer exec phpcbf -- --standard=PSR12 config app tests public

migrate-testing:
	composer exec phinx -- migrate -e testing

rollback-testing:
	composer exec phinx -- rollback -e testing

migrate:
	composer exec phinx -- migrate

rollback:
	composer exec phinx -- rollback

seed:
	composer exec phinx -- seed:run