
Pushing a Docker Image to a Private Repository
Written by: Denis Holdeew
Last updated: November 6, 2023


This tutorial illustrates how to push a Docker image to a private repository. We’ll start by creating a sample application that will be the basis for our Docker image. We’ll then see how to log in to our private Docker repository and finally learn how to tag the image and push it to the repository.

# Private Docker Repositories

Private Docker repositories provide restricted access to the images that they contain. Unlike public repositories, only authorized users can access the images. This way, it’s possible to allow access only to a specific group of users, like organizations, teams, or even a single person. This makes it a perfect choice for projects that don’t want to have their Docker images publicly available.

Making a Docker repository private is done via the repository settings. The details on how this is done may vary for different providers, but usually, it is just a matter of checking a checkbox.

Now that we know what a private Docker repository is good for, let’s explore how to push an image to such a repository. The steps are the same as pushing an image to a public repository. The only difference is that the repository is marked as private.

## Prepare the Image 

First, we need to prepare the image by providing the correct alias and tag optionally. This can be either done while building an image or by using an existing image and renaming it.

First, we create a Docker image from a simple Spring Boot application consisting of a RestController that returns a friendly Hello World! message to the user:

@RestController
public class HelloWorldController {
    @GetMapping("/helloworld")
    String helloWorld() {
        return "Hello World!";
    }
}
We use the following Dockerfile:

FROM openjdk:11
ARG JAR_FILE=target/*.jar
COPY ${JAR_FILE} app.jar
ENTRYPOINT ["java","-jar","/app.jar"]

And finally, we run the command that’ll build the image. It looks like this:

docker build [OPTIONS] PATH | URL | -

In our case, we use the -t option, which tells us that we want to tag the image. We also provide the dot “.” as the PATH to our jar file. Choosing the right name consisting of your user name and the repository name is important. The version tag is optional. In case it is avoided, the image will be tagged with latest:

docker build -t username/fancy-repository:v1.0.0 .
Now we can list the existing images with the following command:

docker images
As a result, we will see the newly created image:

REPOSITORY                  TAG       IMAGE ID        CREATED              SIZE
username/fancy-repository   v1.0.0    e20b5a89a0f2   About a minute ago   665MB
3.2. Prepare an Existing Image

In some cases, we don’t want to create an image from scratch but rather push an existing image. This needs some preparation steps that we’ll explore in this section. Let’s assume we have the following image on our machine:

REPOSITORY       TAG         IMAGE ID       CREATED        SIZE
existing-image   some-tag    e20b5a89a0f2   2 weeks ago   665MB
In order to push it to our fancy-repository, we first need to tag the image with the proper name/alias with the following command:

docker tag SOURCE_IMAGE[:TAG] TARGET_IMAGE[:TAG]
In our example, the SOURCE_IMAGE[:TAG] is the name and the tag of the existing image. The TARGET_IMAGE[:TAG] is the alias consisting of our user name and the name of the repository that we want to push the image to. This is what the command will look like in our example:

docker tag existing-image:some-tag username/fancy-repository:v1.0.0
We can check the result by using the following command:

docker images
Now we can see an additional entry that shows the name of the repository and the newly applied version tag. The image id, the timestamp, and the size are the same because it’s still the same image, just with another alias:

REPOSITORY                      TAG         IMAGE ID        CREATED               SIZE
existing-image                  some-tag    e20b5a89a0f2    2 weeks ago          665MB
username/fancy-repository       v1.0.0      e20b5a89a0f2    2 weeks ago          665MB
With that, we can proceed to push the image to our private repository.

## Push the Image

Now that we have prepared the Docker image, we can push it to our private repository. The first step is to log in to the DockerHub registry with the following command:

docker login
The final step is to push the image with the following command:

docker push [OPTIONS] NAME[:TAG]
In our example, we don’t need to specify any options but only need to provide the image name and the tag. The command will look like this:

docker push username/fancy-repository:v1.0.0
With that, the image will be uploaded to our private Docker repository on DockerHub. We can verify that the image is on DockerHub by running the following command:

docker search username/fancy-repository
As a result, we will get the following output showing our image details and proving that it is actually available on DockerHub:

NAME                        DESCRIPTION   STARS     OFFICIAL   AUTOMATED
username/fancy-repository                 0                             

# Conclusion

In this article, we’ve explored how to push a Docker image to a private repository. We’ve learned what a private repository is and what it’s used for. We then showed how to prepare an image and push it to a private repository.

All code examples mentioned in this article are available over on GitHub.