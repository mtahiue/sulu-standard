server "sulu.webplates.xyz", user: "webplates", roles: [:app, :db, :web]

after "deploy:updated", :build do
    invoke "symfony:console", "sulu:build", "prod --no-interaction"
    invoke "symfony:console", "cache:clear", "--context website"
end
