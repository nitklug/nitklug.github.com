#
# Eases some tasks for the admins
#   `rake' compiles the site locally
#   `rake deploy' pushes it to github
#   `rake publish' compiles locally
#       and deploy it to github
#   `rake post[title-slug]' opens up a
#       new post for you to edit
#

ENV['jekyll-bin']  ||= '/var/lib/gems/1.8/bin/jekyll'
ENV['jekyll-opts'] ||= ''
ENV['destination'] ||= '..'
ENV['baseurl']     ||= 'http://lug.nitk.ac.in'

desc "Run the site through jekyll"
task :jekyll do
    conf = nil
    open('_config.yml') { |f| conf = f.read }
    open('_config.yml', 'w') do |f|
        f.write conf.gsub /baseurl.*$/, "baseurl: #{ENV['baseurl']}"
    end
    sh "#{ENV['jekyll-bin']} #{ENV['destination']} #{ENV['jekyll-opts']}"
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
    puts "#{editor} _posts/#{date}-#{args['slug']}.textile"
    sh "#{editor} _posts/#{date}-#{args['slug']}.textile"
end
