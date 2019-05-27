#!/usr/bin/ruby
require 'json'

STDOUT.sync = true

puts "Your name:"
name = STDIN.gets.chomp
puts "Your age:"
age = STDIN.gets.chomp

if age.match(/[[:alpha:]]/)
    puts "No!No!No!"
    exit
end


string = "{\"name\":\"#{name}\",\"is_admin\":\"no\", \"age\":\"#{age}\"}"
res = JSON.parse(string)

if res['is_admin'] == "yes"
    puts "AIS3{RuBy_js0n_i5_s0_w3ird_0_o}"
else
    puts "Hello, " + res['name']
    puts "You are not admin :("
end

