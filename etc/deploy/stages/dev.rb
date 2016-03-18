server "dev.sulu.webplates.xyz", user: "webplates", roles: [:app, :db, :web]

set :composer_install_flags, "--no-interaction --quiet --optimize-autoloader"

set :symfony_env, "dev"

after "deploy:updated", :build do
    invoke "symfony:console", "sulu:build", "dev --destroy --no-interaction"
    invoke "symfony:console", "sulu:translate:import", "en"
    invoke "symfony:console", "sulu:translate:import", "de"
    invoke "symfony:console", "sulu:translate:export", "en"
    invoke "symfony:console", "sulu:translate:export", "de"
end
