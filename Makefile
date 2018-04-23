deploy-staging:
	npm run build
	rsync -avz --delete dist/* sharecreators:/var/www/sharecreators/staging/html

deploy-production:
	npm run build
	rsync -avz --delete dist/* sharecreators:/var/www/sharecreators/production/html
