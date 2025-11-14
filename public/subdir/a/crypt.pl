#!/usr/bin/perl
use strict;
use lib qw(../..);
use Authen::Passphrase::BlowfishCrypt ();

my %tests = (
	'hello' => '$2y$10$O0fG6ExZRx4mEZxsRHqPKuDy9U2HW9M4UONC1hnsx84tW/bb5URFO',
);

foreach my $password (keys %tests) {
	my $saved_crypt = $tests{$password};
	my $ppr = Authen::Passphrase::BlowfishCrypt->from_crypt($saved_crypt);
	print "Match: " . $ppr->match($password) . "\n";
}
