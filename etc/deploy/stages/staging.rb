server "staging.sulu.webplates.xyz", user: "webplates", roles: [:app, :web, :db]

after "deploy:updated", :build do
    invoke "symfony:console", "sulu:build", "prod --no-interaction"
    invoke "symfony:console", "sulu:translate:import", "en"
    invoke "symfony:console", "sulu:translate:import", "de"
    invoke "symfony:console", "sulu:translate:import", "fr"
    invoke "symfony:console", "sulu:translate:export", "en"
    invoke "symfony:console", "sulu:translate:export", "de"
    invoke "symfony:console", "sulu:translate:export", "fr"
    invoke "symfony:console", "cache:clear", "--context website"
end
