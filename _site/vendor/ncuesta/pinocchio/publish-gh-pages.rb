 #!/usr/bin/env ruby

require 'fileutils'

if `git branch`.split("\n").detect{|x| x.match(/^\*/)}.match(/master/)
  puts "Updating the gh-pages branch"

  myrepo = "git@github.com:ncuesta/pinocchio.git"
  temp = "/tmp/pinocchio-gh-pages"
  docs = "#{temp}/docs"

  `php bin/pinocchio`

  `git clone -b gh-pages #{myrepo} #{temp}`
  FileUtils.mkdir_p(docs)
  FileUtils.cp_r(Dir["doc/*"], docs)
  FileUtils.cd(temp) do
    system("git remote add github #{myrepo}")
    system("git add . && git commit -am 'Re-generating documentation' && git push github gh-pages")
  end
  FileUtils.rm_rf(temp)
end