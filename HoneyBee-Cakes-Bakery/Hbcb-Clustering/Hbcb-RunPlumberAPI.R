
.libPaths()


lapply(.libPaths(), list.files)


if (require("languageserver")) {
  require("languageserver")
} else {
  install.packages("languageserver", dependencies = TRUE,
                   repos = "https://cloud.r-project.org")
}

# STEP 1. Install and load the required packages ----
## plumber ----
if (require("plumber")) {
  require("plumber")
} else {
  install.packages("plumber", dependencies = TRUE,
                   repos = "https://cloud.r-project.org")
}

# STEP 2. Process a Plumber API 
# This allows us to process a plumber API
api <- plumber::plumb("Hbcb-PlumberAPI.R")

# STEP 3 Run the API on a specific port ----

api$run(host = "127.0.0.1", port = 5022)

# Specify a constant localhost port to use

