subsummarizeTable
=================
subsummarizeTable is a little php function I wrote that will take an array (or object)
of rows or records and, grouping them by one of the fields, subsummarize them for display.

free to distribute. have at it.

@author www.fredtranfield.com

This means an array of rows like this:

Name 		|		Spent
----------------
Tom			|		10	
Jane		|		8
Jane		|		16
Tom			|		6

Becomes an array of rows like this:

Name 		|		Spent
----------------
Tom			|		10	
Tom			|		6
----------------
Summary			16
----------------
Jane		|		8
Jane		|		16
----------------
Summary |		24
