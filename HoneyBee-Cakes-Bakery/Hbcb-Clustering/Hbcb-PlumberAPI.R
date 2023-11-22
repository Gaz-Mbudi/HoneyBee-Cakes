
.libPaths()

# One of the libraries should be a folder inside the project if you are using
# renv

# Then execute the following command to see which packages are available in
# each library:
lapply(.libPaths(), list.files)



if (require("languageserver")) {
  require("languageserver")
} else {
  install.packages("languageserver", dependencies = TRUE,
                   repos = "https://cloud.r-project.org")
}

## plumber ----
if (require("plumber")) {
  require("plumber")
} else {
  install.packages("plumber", dependencies = TRUE,
                   repos = "https://cloud.r-project.org")
}

## caret ----
if (require("caret")) {
  require("caret")
} else {
  install.packages("caret", dependencies = TRUE,
                   repos = "https://cloud.r-project.org")
}

#load model
model_to_predict_clusters <- readRDS("Hbcb_customer_segmentation_model.rds")

#STEP 1 Creating the REST API using Plumber

#* @apiTitle Customer Segment Prediction Model API

#* @apiDescription Used to predict which segment a customer belongs to.

#* @param arg_productId The type of cake
#* @param arg_qunatity The number of cakes bought

#* @get /segment


predict_cluster <- function(arg_productId, arg_quantity) {
  # Create a data frame using the arguments
  to_be_predicted <- data.frame(productId = as.numeric(arg_productId), quantity = as.numeric(arg_quantity))
  
  # Perform k-means clustering on the input data to obtain clusters
  # to_be_predicted$cluster <- predict(model_to_predict_clusters, to_be_predicted)
  
  
  # Predict the cluster using the model_to_predict_clusters
  predict(model_to_predict_clusters, newdata = to_be_predicted)
}


