## MVC
- stand for **Model View Controller**
- software architectural design pattern
- one of the most frequently used patterns
- separates application functions
- promotes organization

## Model
- data related logic
- interacts with the database (SELECT, INSERT, UPDATE, DELETE)
- communicate with Controller
- Can sometime update the VIEW

## View
- what the user sees in the browser (UI)
- Usually Consists of HTML/CSS
- Communicates with the controller
- Can the passes dynamic values from controller

## Controller
- Receives input from the url, from, view, etc
- Processes request (GET, POST, etc)
- Gets data from the model
- Passes data to the view

## structure for this core
- url: /class/method/params
- controller work as a class
