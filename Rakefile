#
# Eases some tasks for the admins
#   `rake' compiles the site locally
#   `rake deploy' pushes it to github
#   `rake publish' compiles locally
#       and deploy it to github
#   `rake post[title-slug]' opens up a
#       new post for you to edit
#

require 'yaml'

ENV['jekyll-bin']  ||= '/var/lib/gems/1.8/bin/jekyll'
ENV['jekyll-opts'] ||= ''
ENV['destination'] ||= '..'

desc "Run the site through jekyll"
task :jekyll do
    sh "git show local-config:_config.yml > _config.yml"
    sh "#{ENV['jekyll-bin']} #{ENV['destination']} #{ENV['jekyll-opts']}"
    sh "git checkout _config.yml"
end

desc "deploy to github"
task :deploy do
    stat = `git status --porcelain`
    if stat != "" then
        puts "Working directory is not clean, first commit the changes:\n" +
             "  git add .\n" +
             "  git commit -m 'Commit message'"
        exit 1
    end
    
    # git dir is clean, deploy
    sh "git push git@github.com:nitklug/nitklug.github.com HEAD"
end

desc "Publish changes locally and on github"
task :publish => [:jekyll, :deploy]

desc "Write a new post"
task :post, :slug, :editor do |t, args|
    editor = args['editor'] || ENV['EDITOR'] || `git config core.editor` || 'vi'
    editor.strip!
    date = Time.now.strftime('%Y-%m-%d')
    file = "_posts/#{date}-#{args['slug']}.textile"
    sh "#{editor} #{file}"
    authornick = nil
    open(file) { |f| authornick = YAML::load(f.read)['author'] }
    if authornick then
        links = nil
        linksfile = '_includes/links.textile'
        open(linksfile) { |f| links = f.read }
        links = links.grep /\[#{authornick}\]/
        if links.size == 0 then
            email = `git config user.email`.strip
            print "Url/email for #{authornick} (hit return to use '#{email}'): "
            url = STDIN.gets.strip
            url = "mailto:#{email}" if email.include? '@'
            link = "[#{authornick}]#{url.strip}"
            open(linksfile, 'a') { |f| f.write "\n#{link}" }
        end
    end
end
