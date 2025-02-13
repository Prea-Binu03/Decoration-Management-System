-- Drop the existing permissions table if it exists
DROP TABLE IF EXISTS `permissions`;

-- Create the permissions table
CREATE TABLE `permissions` (
    `id` int(11) NOT NULL,
    `permission` varchar(255) CHARACTER SET latin1 NOT NULL,
    `createuser` varchar(255) DEFAULT NULL,
    `deleteuser` varchar(255) DEFAULT NULL,
    `createbid` varchar(255) DEFAULT NULL,
    `updatebid` varchar(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Insert data into the permissions table
INSERT INTO
    `permissions` (
        `id`,
        `permission`,
        `createuser`,
        `deleteuser`,
        `createbid`,
        `updatebid`
    )
VALUES (
        1,
        'Superuser',
        NULL,
        '1',
        '1',
        '1'
    ),
    (
        2,
        'Admin',
        '1',
        NULL,
        '1',
        '1'
    ),
    (
        3,
        'User',
        NULL,
        NULL,
        '1',
        NULL
    );

-- Drop the existing tbladmin table if it exists
DROP TABLE IF EXISTS `tbladmin`;

-- Create the tbladmin table
CREATE TABLE `tbladmin` (
    `ID` int(10) NOT NULL,
    `Staffid` varchar(255) DEFAULT NULL,
    `AdminName` varchar(120) DEFAULT NULL,
    `UserName` varchar(120) DEFAULT NULL,
    `FirstName` varchar(255) DEFAULT NULL,
    `LastName` varchar(255) DEFAULT NULL,
    `MobileNumber` bigint(10) DEFAULT NULL,
    `Email` varchar(200) DEFAULT NULL,
    `Status` int(11) NOT NULL DEFAULT 1,
    `Photo` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'avatar15.jpg',
    `Password` varchar(120) DEFAULT NULL,
    `AdminRegdate` timestamp NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`ID`)
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

-- Insert data into the tbladmin table
INSERT INTO
    `tbladmin` (
        `ID`,
        `Staffid`,
        `AdminName`,
        `UserName`,
        `FirstName`,
        `LastName`,
        `MobileNumber`,
        `Email`,
        `Status`,
        `Photo`,
        `Password`,
        `AdminRegdate`
    )
VALUES (
        2,
        '10002',
        'Admin',
        'admin',
        'John',
        'Smith',
        770546590,
        'admin@gmail.com',
        1,
        'face19.jpg',
        '81dc9bdb52d04dc20036dbd8313ed055',
        '2021-06-21 10:18:39'
    ),
    (
        9,
        '10003',
        'Admin',
        'harry',
        'Harry',
        'Ronald',
        757537271,
        'harry@gmail.com',
        1,
        'face27.jpg',
        '81dc9bdb52d04dc20036dbd8313ed055',
        '2021-06-21 07:08:48'
    ),
    (
        29,
        'U002',
        'User',
        'morgan',
        'Happy',
        'Morgan',
        770546590,
        'morgan@gmail.com',
        1,
        'avatar15.jpg',
        '81dc9bdb52d04dc20036dbd8313ed055',
        '2021-07-21 14:26:42'
    );

-- Drop the existing tblusers table if it exists
DROP TABLE IF EXISTS `tblusers`;

-- Create the tblusers table
CREATE TABLE `tblusers` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `FullName` varchar(100) DEFAULT NULL,
    `MobileNumber` char(10) DEFAULT NULL,
    `EmailId` varchar(70) DEFAULT NULL,
    `Password` varchar(100) DEFAULT NULL,
    `RegDate` timestamp NULL DEFAULT current_timestamp(),
    `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp(),
    PRIMARY KEY (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = latin1;

-- Insert data into the tblusers table
INSERT INTO
    `tblusers` (
        `id`,
        `FullName`,
        `MobileNumber`,
        `EmailId`,
        `Password`,
        `RegDate`,
        `UpdationDate`
    )
VALUES (
        14,
        'Gerald Brain',
        '0770546590',
        'gerald@gmail.com',
        '81dc9bdb52d04dc20036dbd8313ed055',
        '2020-01-15 14:00:35',
        '2021-07-24 09:49:44'
    ),
    (
        16,
        'John Smith',
        '0770546590',
        'admin@gmail.com',
        '81dc9bdb52d04dc20036dbd8313ed055',
        '2021-07-24 08:34:08',
        NULL
    );

-- Drop the existing tblbooking table if it exists
DROP TABLE IF EXISTS `tblbooking`;

-- Create the tblbooking table
CREATE TABLE `tblbooking` (
    `BookingId` INT AUTO_INCREMENT PRIMARY KEY,
    `id` INT,
    `PackageId` INT,
    `FromDate` DATE,
    `ToDate` DATE,
    `Comment` TEXT,
    `RegDate` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `Status` VARCHAR(50),
    `CancelledBy` VARCHAR(100),
    `UpdationDate` TIMESTAMP,
    `PackagePaymentMode` VARCHAR(50),
    `PaymentStatus` VARCHAR(50),
    `PaymentAmount` DECIMAL(10, 2),
    FOREIGN KEY (`id`) REFERENCES `tblusers` (`id`)
) ENGINE = InnoDB DEFAULT CHARSET = latin1;
-- Dumping data for table `tblusers`
--



CREATE TABLE `tbltourpackages` (
    `PackageId` int(11) NOT NULL AUTO_INCREMENT,
    `PackageName` varchar(100) NOT NULL,
    `PackageType` varchar(100) NOT NULL,
    `PackageLocation` varchar(100) NOT NULL,
    `PackagePrice` float NOT NULL,
    `PackageFeatures` mediumtext NOT NULL,
    `PackageDetails` mediumtext NOT NULL,
    `PackageImage` varchar(255) DEFAULT NULL, -- Image for packages
    `CreationDate` timestamp NOT NULL DEFAULT current_timestamp(),
    PRIMARY KEY (`PackageId`)
) ENGINE = InnoDB DEFAULT CHARSET = latin1;
--
-- Dumping data for table `tbltourpackages`
--

INSERT INTO
    `tbltourpackages` (
        `PackageId`,
        `PackageName`,
        `PackageType`,
        `PackageLocation`,
        `PackagePrice`,
        `PackageFeatures`,
        `PackageDetails`,
        `PackageImage`,
        `CreationDate`
    )
VALUES (
        1,
        'Anniversary Decor Package',
        'The Anniversary Decor Package specializes in creating memorable and romantic atmospheres for anniversary celebrations, featuring personalized decorations and customized themes.',
        'Available at various venues, including banquet halls, hotels, outdoor gardens, and private residences.',
        45000.00,
        'Elegant and romantic decorations, Customizable themes and color schemes, Balloon and floral arrangements, Decorative lighting and candles, Table and chair decor, Anniversary banners and signage, Photo booth setup, On-site decoration support',
        'An anniversary decor package typically includes a variety of themed decorations designed to create a memorable and festive atmosphere. This package often features balloons, banners, and tableware that match the chosen theme. Additionally, it includes lighting setups to enhance the ambiance, floral arrangements for a touch of elegance, and customized backdrops for photo opportunities. To make the event more interactive, photo booth props are also provided. Overall, the package aims to deliver a cohesive and visually appealing decor setup that enhances the celebration.',
        'Anniversary.jpg',
        '2023-09-01 10:00:00'
    ),
    (
        2,
        'Baby Shower Decor Package',
        'Baby shower decor packages typically include themed decorations, balloon arches or columns, table linens, centerpieces, and a decorated cake table.',
        'Available at banquet halls, hotels, private residences, outdoor gardens, community centers, and restaurants.',
        65000.00,
        'Themed decorations, Balloon arches or columns, Table linens, Centerpieces, Decorated cake table, Floral arrangements, Customized backdrops, Photo booth props',
        'A baby shower decor package typically includes a range of themed decorations to celebrate the upcoming arrival of a baby. This package often features balloon arches or columns, table linens, and centerpieces that match the chosen theme. Additionally, it includes a decorated cake table to serve as a focal point, along with floral arrangements to add a touch of elegance. Customized backdrops are provided for photo opportunities, and photo booth props are included to make the event more interactive and fun. Overall, the package aims to create a joyful and memorable atmosphere for the celebration.',
        'Baby Shower.jpg',
        '2023-09-02 10:30:00'
    ),
    (
        3,
        'Balloon Decor Package',
        'Balloon decor packages typically include balloon arches, garlands, columns, centerpieces, and backdrops.',
        'Available at halls, hotels, homes, gardens, centers, restaurants.',
        1500.00,
        'Balloon arches, Balloon garlands, Balloon columns, Balloon centerpieces, Balloon backdrops, Themed balloon designs, Custom color schemes',
        'A balloon decor package typically includes a variety of balloon arrangements designed to enhance the visual appeal of any event. This package often features balloon arches, garlands, and columns that can be customized to match the event’s theme and color scheme. Additionally, balloon centerpieces and backdrops are included to create focal points and photo opportunities. Themed balloon designs and custom color schemes add a personalized touch to the decor. Overall, the package aims to provide a festive and vibrant atmosphere, making the event memorable and visually stunning.',
        'Ballon.jpg',
        '2023-09-03 11:00:00'
    ),
    (
        4,
        'Birthday Decor Package',
        'Birthday decor packages typically include balloons, banners, tableware, centerpieces, and themed decorations.',
        'Available at banquet halls, hotels, homes, gardens, centers, restaurants.',
        25000.00,
        'Themed decorations, Balloons and banners, Tableware and centerpieces, Lighting and ambiance setup, Customized backdrops, Photo booth props, Cake table decor, Party favors',
        'A birthday decor package typically includes a variety of themed decorations to create a festive and joyful atmosphere. This package often features balloons and banners that match the chosen theme, along with tableware and centerpieces to enhance the overall look. Additionally, lighting setups are included to set the right ambiance, and customized backdrops are provided for memorable photo opportunities. The package also includes photo booth props to make the event more interactive and fun, as well as cake table decor to highlight the celebration’s centerpiece. Party favors are often included to give guests a small token to remember the event by. Overall, the package aims to deliver a cohesive and visually appealing decor setup that makes the birthday celebration special and memorable.',
        'Birthday.jpg',
        '2023-09-02 10:30:00'
    ),
    (
        5,
        'Engagement Decor Package',
        'Engagement decor packages typically include romantic and elegant decorations designed to celebrate the engagement, including floral arrangements, lighting, and thematic elements.',
        'Available at banquet halls, hotels, private residences, gardens, and restaurants.',
        50000.00,
        'Romantic and elegant decorations, Floral arrangements, Thematic elements, Custom lighting setups, Table and chair decor, Engagement backdrop, Photo booth props, On-site support',
        'An engagement decor package typically includes a range of romantic and elegant decorations designed to celebrate the engagement of a couple. This package often features floral arrangements, thematic elements, and custom lighting setups to create a warm and intimate atmosphere. Additionally, it includes table and chair decor, an engagement backdrop for photo opportunities, and photo booth props to make the event more interactive and fun. On-site support is also provided to ensure everything goes smoothly. Overall, the package aims to deliver a sophisticated and memorable decor setup that enhances the engagement celebration.',
        'Engagement.jpg',
        '2023-09-04 11:00:00'
    ),
    (
        6,
        'Proposal Decor Package',
        'Proposal decor packages typically include romantic and elaborate decorations to create a memorable proposal setting, such as floral arrangements, lighting, and personalized elements.',
        'Available at scenic locations, private venues, and restaurants.',
        60000.00,
        'Romantic and elaborate decorations, Floral arrangements, Customized lighting, Personalized elements, Proposal backdrop, Table and chair decor, On-site support',
        'A proposal decor package typically includes a range of romantic and elaborate decorations designed to create a memorable and impactful proposal setting. This package often features floral arrangements, customized lighting, and personalized elements that reflect the couple’s style and preferences. Additionally, it includes a proposal backdrop to enhance the visual appeal, table and chair decor for added elegance, and on-site support to ensure everything is perfect. Overall, the package aims to deliver a romantic and unforgettable atmosphere that enhances the proposal experience.',
        'Proposal.jpg',
        '2023-09-05 10:30:00'
    ),
    (
        7,
        'Wedding Decor Package',
        'Wedding decor packages typically include comprehensive decorations for weddings, including floral arrangements, lighting, table settings, and thematic elements.',
        'Available at wedding venues, banquet halls, hotels, and private residences.',
        200000.00,
        'Comprehensive wedding decorations, Floral arrangements, Custom lighting, Table settings, Thematic elements, Wedding backdrop, Photo booth setup, On-site support',
        'A wedding decor package typically includes a comprehensive range of decorations designed to enhance the wedding ceremony and reception. This package often features elegant floral arrangements, custom lighting setups, and themed table settings that match the wedding’s overall theme. Additionally, it includes a wedding backdrop for memorable photos, a photo booth setup for interactive fun, and on-site support to ensure everything goes smoothly. Overall, the package aims to provide a cohesive and beautiful decor setup that makes the wedding day truly special and unforgettable.',
        'Wedding.jpg',
        '2023-09-06 11:00:00'
    ),
    (
        8,
        'Corporate Decor Package',
        'Corporate decor packages typically include professional and stylish decorations designed for business events and corporate functions.',
        'Available at corporate venues, conference halls, hotels, and office spaces.',
        75000.00,
        'Elegant and professional decorations, Themed setups, Branded elements, Table settings, Lighting and ambiance, Custom backdrops, Audio-visual equipment setup, On-site support',
        'A corporate decor package typically includes a range of professional and stylish decorations designed to enhance business events and corporate functions. This package often features elegant and branded elements, themed setups to align with the company’s image, and sophisticated table settings. Additionally, lighting and ambiance are carefully planned to create a polished atmosphere, with customized backdrops for company branding. The package also includes audio-visual equipment setup for presentations or speeches and on-site support to ensure smooth execution. Overall, the package aims to deliver a professional and impressive decor setup for corporate events.',
        'Corporate.jpeg',
        '2023-09-08 16:00:00'
    );

  CREATE TABLE tblservice (
    ServiceId INT AUTO_INCREMENT PRIMARY KEY, -- Enable auto-increment
    ServiceName VARCHAR(100) NOT NULL,
    ServiceDescription TEXT NOT NULL,
    ServiceCost DECIMAL(10, 2) NOT NULL,
    Status TINYINT(1) DEFAULT 1,
    ServiceImage VARCHAR(255)
) ENGINE = InnoDB DEFAULT CHARSET = latin1;
INSERT INTO
    `tblservice` (
        `ServiceName`,
        `ServiceDescription`,
        `ServiceCost`,
        `Status`,
        `ServiceImage`
    )
VALUES (
        'Backdrop',
        'Elegant and customizable backdrops to enhance any event\'s atmosphere with personalized designs and color schemes.',
        150.00,
        1,
        'backdrop.jpg'
    ),
    (
        'Ball Decoration Light Service',
        'Vibrant balloon decor with integrated lighting to add a glowing touch to your celebrations.',
        180.00,
        1,
        'ball decoration light.jpg'
    ),
    (
        'Crystal string lights',
        'Delicate crystal string lights that create a sparkling and elegant ambiance for any event.',
        140.00,
        1,
        'Crystal string lights.jpg'
    ),
    (
        'Dreamcatchers',
        'Beautifully crafted dreamcatchers that bring a touch of whimsy and serenity to your décor.',
        160.00,
        1,
        'dreamcatchers.jpeg'
    ),
    (
        'fairylight',
        'Beautifully crafted dreamcatchers that bring a touch of whimsy and serenity to your décor.',
        188.00,
        1,
        'fairylight.jpg'
    ),
    (
        'net decorative hanging',
        'Stylish net decorative hangings that add texture and elegance, perfect for enhancing any space.',
        130.00,
        1,
        'net decorative hanging.jpg'
    ),
    (
        'Star Curtain LED lights',
        'Enchanting star curtain LED lights that create a magical and twinkling backdrop for any event.',
        140.00,
        1,
        'Star Curtain LED lights.jpg'
    ),
    (
        'table decor',
        'Elegant table decor that enhances your dining experience with beautiful centerpieces and tasteful accents.',
        190.00,
        1,
        'table decor.jpg'
    ),
    (
        'wall art',
        'Eye-catching wall art pieces designed to infuse personality and style into your space.',
        140.00,
        1,
        'wall art.jpg'
    ),
    (
        'Wall hanging light',
        'Chic wall hanging lights that combine illumination with decorative charm to elevate any room\'s ambiance.',
        150.00,
        1,
        'Wall hanging light.jpg'
    ),
    (
        'wall hanging',
        'Stylish wall hangings that add a unique artistic flair to your space, enhancing the overall décor.',
        160.00,
        1,
        'wall hanging.jpg'
    );
CREATE TABLE tblbookingservices (
    BookingServiceId INT AUTO_INCREMENT PRIMARY KEY,  -- Primary key for booking services
    BookingId INT,  -- Foreign key to reference booking table
    ServiceId INT,  -- Foreign key to reference service table
    UserId INT,  -- Foreign key to reference users table
    Quantity INT,  -- Quantity of the service booked
    Status VARCHAR(50),  -- Status of the service booking (e.g., confirmed, pending, cancelled)
    PaymentOption VARCHAR(50),  -- Payment option used (e.g., Credit Card, Google Pay)
    PaymentStatus VARCHAR(50),  -- Payment status (e.g., paid, unpaid)
    PaymentAmount DECIMAL(10, 2),  -- Amount paid for the service
    Comment TEXT,  -- Additional comments for the service
    FOREIGN KEY (BookingId) REFERENCES tblbooking (BookingId),  -- Foreign key referencing tblbooking
    FOREIGN KEY (ServiceId) REFERENCES tblservice (ServiceId),  -- Foreign key referencing tblservice
    FOREIGN KEY (UserId) REFERENCES tblusers (id)  -- Foreign key referencing tblusers
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `tblcompany` (
    `id` int(11) NOT NULL,
    `regno` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
    `companyname` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
    `companyemail` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
    `country` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
    `companyphone` int(10) NOT NULL,
    `companyaddress` varchar(255) CHARACTER SET latin1 NOT NULL,
    `companylogo` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'avatar15.jpg',
    `status` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '0',
    `developer` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
    `creationdate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Dumping data for table `tblcompany`
--

INSERT INTO
    `tblcompany` (
        `id`,
        `regno`,
        `companyname`,
        `companyemail`,
        `country`,
        `companyphone`,
        `companyaddress`,
        `companylogo`,
        `status`,
        `developer`,
        `creationdate`
    )
VALUES (
        4,
        '1002',
        'St. Paul Church',
        'stpaul@gmail.com',
        'Uganda',
        770546590,
        'Kyebando',
        'church.jpg',
        '1',
        'gerald',
        '2021-02-02 12:17:15'
    );