server "dev.sulu.io", user: "sulu", roles: [:app, :web]

after "deploy:updated", :build do
    invoke "symfony:console", "sulu:build", "dev --no-interaction"
    invoke "symfony:console", "sulu:translate:import", "en"
    invoke "symfony:console", "sulu:translate:import", "de"
    invoke "symfony:console", "sulu:translate:export", "en"
    invoke "symfony:console", "sulu:translate:export", "de"
end
