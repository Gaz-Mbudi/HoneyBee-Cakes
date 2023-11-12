
.libPaths()


lapply(.libPaths(), list.files)


if (require("languageserver")) {
  require("languageserver")
} else {
  install.packages("languageserver", dependencies = TRUE,
                   repos = "https://cloud.r-project.org")
}


# STEP 1. Install and Load the Required Packages ----
## readr ----
if (require("readr")) {
  require("readr")
} else {
  install.packages("readr", dependencies = TRUE,
                   repos = "https://cloud.r-project.org")
}

## naniar ----
if (require("naniar")) {
  require("naniar")
} else {
  install.packages("naniar", dependencies = TRUE,
                   repos = "https://cloud.r-project.org")
}

## ggplot2 ----
if (require("ggplot2")) {
  require("ggplot2")
} else {
  install.packages("ggplot2", dependencies = TRUE,
                   repos = "https://cloud.r-project.org")
}

## corrplot ----
if (require("corrplot")) {
  require("corrplot")
} else {
  install.packages("corrplot", dependencies = TRUE,
                   repos = "https://cloud.r-project.org")
}

## ggcorrplot ----
if (require("ggcorrplot")) {
  require("ggcorrplot")
} else {
  install.packages("ggcorrplot", dependencies = TRUE,
                   repos = "https://cloud.r-project.org")
}

## caret ----
if (require("caret")) {
  require("caret")
} else {
  install.packages("caret", dependencies = TRUE,
                   repos = "https://cloud.r-project.org")
}

## tidyverse ----
if (require("tidyverse")) {
  require("tidyverse")
} else {
  install.packages("tidyverse", dependencies = TRUE,
                   repos = "https://cloud.r-project.org")
}

## plumber ----
if (require("plumber")) {
  require("plumber")
} else {
  install.packages("plumber", dependencies = TRUE,
                   repos = "https://cloud.r-project.org")
}

# STEP 2. Load the Dataset ----

library(readr)
Hbcb_training_data <- read_csv("Hbcb-training-data.csv")
View(Hbcb_training_data)

str(Hbcb_training_data)
dim(Hbcb_training_data)
head(Hbcb_training_data)
summary(Hbcb_training_data)

# STEP 3. Check for Missing Data and Address it ----
# Are there missing values in the dataset?
any_na(Hbcb_training_data)

# How many?
n_miss(Hbcb_training_data)

# What is the proportion of missing data in the entire dataset?
prop_miss(Hbcb_training_data)

# What is the number and percentage of missing values grouped by
# each variable?
miss_var_summary(Hbcb_training_data)



# STEP 4. Perform EDA and Feature Selection ----
## Compute the correlations between variables ----
# We identify the correlated variables because it is these correlated variables
# that can then be used to identify the clusters.


## Plot the scatter plots ----
# A scatter plot to show Cake type against quantity
ggplot(Hbcb_training_data, aes(x=productId, y=quantity)) +
  geom_point() +
  geom_smooth(method="lm", se=FALSE) +
  labs(title="Cake analysis",
       subtitle="Relationship between Type of cake and quantity") +
  theme_bw()


#STEP 5. Training the Model
# Select relevant columns for clustering
data_for_clustering <- Hbcb_training_data[, c("productId", "quantity")]

# Standardize the data (optional but often recommended for k-means)
scaled_data <- scale(data_for_clustering)

# Perform k-means clustering with 4 clusters
k <- 4  # Replace with the desired number of clusters
kmeans_result <- kmeans(scaled_data, centers = k)

# Add the cluster assignments back to the original data frame
Hbcb_training_data$cluster <- kmeans_result$cluster

# Print the results
print(kmeans_result)
print(Hbcb_training_data)

# Create a scatter plot with different colors for each cluster
ggplot(Hbcb_training_data, aes(x = productId, y = quantity, color = factor(cluster))) +
  geom_point() +
  labs(title = "K-Means Clustering",
       x = "Product ID",
       y = "Quantity") +
  theme_minimal()


# STEP 5. Save and Load your Model ----
# Saving a model into a file allows you to load it later and use it to make
# predictions. Saved models can be loaded by calling the `readRDS()` function

saveRDS(Hbcb_training_data, "./Hbcb_training_data.rds")
# The saved model can then be loaded later as follows:
loaded_Hbcb_training_data <- readRDS("./Hbcb_training_data.rds")
print(loaded_Hbcb_training_data)

#predictions_with_loaded_model <-
 # predict(loaded_Hbcb_training_data, newdata = user_cluster)
#confusionMatrix(predictions_with_loaded_model, user_cluster$cluster)


# STEP 6. Creating Functions in R ----

# Plumber requires functions, an example of the syntax for creating a function
# in R is:

name_of_function <- function(arg) {
  # Do something with the argument called `arg`
}

# STEP 7. Make Predictions on New Data using the Saved Model ----
# We can also create and use our own data frame as follows:
#to_be_predicted <-
 # data.frame(pregnant = 6, glucose = 148, pressure = 72, triceps = 35,
 #            insulin = 0, mass = 33.6, pedigree = 0.627, age = 50)

# We then use the data frame to make predictions
#predict(loaded_diabetes_model_lda, newdata = to_be_predicted)

# STEP 8. Make predictions using the model through a function ----
# An alternative is to create a function and then use the function to make
# predictions

predict_cluster <- function(arg_productId, arg_quantity) {
  to_be_predicted <- data.frame(productId = as.numeric(arg_productId), quantity = as.numeric(arg_quantity))
  # Make sure 'loaded_Hbcb_training_data' is a model object (e.g., created using kmeans)
  predict(loaded_Hbcb_training_data, to_be_predicted)
}



# We can now call the function predict_diabetes() instead of calling the
# predict() function directly

#predict_cluster(3, 4)

#predict_cluster(1, 85, 66, 29, 0, 26.6, 0.351, 31)


loaded_Hbcb_training_data <- readRDS("./Hbcb_training_data.rds")

#* @apiTitle Customer Cluster Predition API

#* @apiDescription Used to predict Which cluster a customer falls in

#* @param arg_productId cake type
#* @param arg_quantity number of cakes


#* @get /cluster

predict_cluster <-
  function(arg_productId, arg_quantity) {
    # Create a data frame using the arguments
    to_be_predicted <-
      data.frame(productId = as.numeric(arg_productId),
                 quantity = as.numeric(arg_quantity))
    # Make a prediction based on the data frame
    predict(loaded_Hbcb_training_data, to_be_predicted)
  }


# STEP 2. Process a Plumber API ----
# This allows us to process a plumber API
api <- plumber::plumb("Hbcb-Clustering-Model.R")

# STEP 3. Run the API on a specific port ----
# Specify a constant localhost port to use
api$run(host = "127.0.0.1", port = 5022)


