# take a look at .htaccess
- top level - framwork
    - it rewrite the access to public folder
    - it bypass the keyword ?url= on the url, so that we can access the param right on the url
- at app level
    - it block the access of indexes
- at public folder level
    - it rewrite the 404 path to default index.php