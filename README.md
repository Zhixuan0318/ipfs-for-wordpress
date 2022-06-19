# IPFS for Wordpress

## Process of adding an image (Pinata, Web3.Storage and Nft.Storage)
1. Click the `Add image to Pinata` button
2. A popup will be displayed, user need to:
   * Upload the image
   * Name (User need to give this upload a name (this name will store locally on server storage (MySQL), not on IPFS), however this is optional. If the user doesnt give this upload a name, the image name will be the CID (which return after the IPFS storing succeed). If the user give the upload a name, after the image is retrieve and display in library, the image name will be the name given during the upload popup.) **FOR A MORE CLEARER IDEA, READ `Design Scheme of Database`**

### Design scheme of database
Let's say we have a "image" table, we have two attribute:
1. CID
2. Image Name:

    Every image added by the user will have this two attribute, CID is a must (this make sense as uploading to IPFS tools will sure have a CID returned.) However, name will be optional, it may be NULL or have a name given when the user upload this image. Of course, if user didn't give the image a name when upload, it can choose to give it a name in the future (we will then just need to update the image name for that CID in the table).

3. alt tag
   
   Here is how you store an alt tag, we store it locally. Everytime user upload an image, the image will automatically have the `alt` attribute, initially it is a NULL. User can set this `alt` attribute through the UI. Hence, we do not store the alt to IPFS.
